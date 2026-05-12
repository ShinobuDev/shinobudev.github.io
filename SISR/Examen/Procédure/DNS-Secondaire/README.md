# Procédure d'installation — Serveur DNS secondaire Linux (BIND9)
Serveur : DNS-LINUX | OS : Debian 13 (Trixie)  
DNS maître : LABANNU1 Windows AD — 172.16.0.105  
Date : Mai 2026

---

## Sommaire

### 🔶 PHASE 1 — Internet (vmbr0, DHCP) : installation
1. [Prérequis et préparation du serveur](#1-prérequis-et-préparation-du-serveur)
2. [Installation de BIND9](#2-installation-de-bind9)
3. [Configuration de BIND9 en secondaire](#3-configuration-de-bind9-en-secondaire)

### 🔷 PHASE 2 — Réseau GSB (vmbr1, IP fixe) : intégration
4. [Bascule réseau vers vmbr1](#4-bascule-réseau-vers-vmbr1)
5. [Autorisation du transfert de zone sur LABANNU1](#5-autorisation-du-transfert-de-zone-sur-labannu1)
6. [Vérification du transfert de zone](#6-vérification-du-transfert-de-zone)
7. [Tests de validation](#7-tests-de-validation)
8. [Tableau récapitulatif des ports](#8-tableau-récapitulatif-des-ports)

---

## 🔶 PHASE 1 — Internet (vmbr0, DHCP)

> **Avant de commencer** : dans Proxmox, la carte réseau de la VM doit être sur **vmbr0** pour l'accès Internet.

---

## 1. Prérequis et préparation du serveur

### 1.1 Informations du serveur

| Paramètre       | Valeur                             |
|-----------------|------------------------------------|
| Nom d'hôte      | `dns-linux.gsb.local`              |
| Adresse IP      | À définir (ex: `172.16.0.11/17`)   |
| Passerelle      | `172.16.127.254`                   |
| DNS maître      | `172.16.0.105` (LABANNU1 AD)       |
| Domaine         | `gsb.local`                        |
| Zone à répliquer | `gsb.local`                       |
| OS              | Debian 13 trixie                   |
| Rôle            | DNS secondaire (slave BIND9)       |

### 1.2 Configuration réseau PHASE 1 (vmbr0, DHCP)

Vérifier que `/etc/network/interfaces` contient :

```
auto lo
iface lo inet loopback

auto ens18
iface ens18 inet dhcp
```

```bash
systemctl restart networking
ping -c 3 8.8.8.8    # vérifier l'accès Internet
```

### 1.3 Nom d'hôte et mise à jour

```bash
hostnamectl set-hostname dns-linux.gsb.local
apt update -y
apt install -y vim net-tools ufw dnsutils
```

### 1.4 Pare-feu UFW

```bash
ufw allow 22/tcp    # SSH
ufw allow 53/tcp    # DNS (transfert de zone)
ufw allow 53/udp    # DNS (requêtes)
ufw enable
ufw status verbose
```

---

## 2. Installation de BIND9

```bash
apt install -y bind9 bind9utils bind9-doc
```

Vérifier que le service est actif :

```bash
systemctl status bind9
# → active (running)

# Vérifier l'écoute sur le port 53
ss -tlnup | grep named
# → ports 53 TCP et UDP
```

---

## 3. Configuration de BIND9 en secondaire

### 3.1 Configuration principale — `/etc/bind/named.conf.options`

```bash
nano /etc/bind/named.conf.options
```

```conf
options {
    directory "/var/cache/bind";

    // ================================================================
    // Écoute sur toutes les interfaces
    // ================================================================
    listen-on { };
    listen-on-v6 { none; };

    // ================================================================
    // Serveurs auxquels on fait confiance pour les transferts de zone
    // LABANNU1 = maître, LABANNU2 = secondaire AD existant
    // ================================================================
    allow-transfer { none; };     // interdit par défaut
    allow-query { yes; };

    // ================================================================
    // Résolution récursive — autorisée seulement pour le réseau GSB
    // ================================================================
    recursion yes;
    allow-recursion { 127.0.0.0/8; 172.16.0.0/17; };

    // ================================================================
    // Forwarders : si BIND9 ne connaît pas la zone, il interroge
    // LABANNU1 en premier, puis le DNS public en fallback
    // ================================================================
    forwarders {
        172.16.0.105;    // LABANNU1 (AD Windows)
        172.16.0.106;    // LABANNU2 (AD Windows)
        8.8.8.8;         // Google DNS (fallback internet)
        1.1.1.1;         // Cloudflare DNS (fallback internet)
    };
    forward only;

    // ================================================================
    // Sécurité
    // ================================================================
    dnssec-validation no;         // désactivé — l'AD Windows ne signe pas
    version "none";               // ne pas divulguer la version de BIND9
    auth-nxdomain no;

    // Logs
    querylog yes;
};
```

### 3.2 Déclaration de la zone esclave — `/etc/bind/named.conf.local`

```bash
nano /etc/bind/named.conf.local
```

```conf
// ================================================================
// Zone directe gsb.local — esclave (secondaire) de LABANNU1
// ================================================================
zone "gsb.local" {
    type slave;
    masters { 172.16.0.105; };      // LABANNU1 Windows AD
    file "/var/cache/bind/gsb.local.slave";   // fichier de zone local
};

// ================================================================
// Zone inverse — esclave de LABANNU1
// 172.16.0.0/17 → reverse: 16.172.in-addr.arpa
// ================================================================
zone "16.172.in-addr.arpa" {
    type slave;
    masters { 172.16.0.105; };
    file "/var/cache/bind/16.172.in-addr.arpa.slave";
};
```

### 3.3 Permissions sur le répertoire de cache

```bash
# BIND9 doit pouvoir écrire le fichier de zone téléchargé
chown -R bind:bind /var/cache/bind
chmod 755 /var/cache/bind
```

### 3.4 Vérification de la syntaxe et redémarrage

```bash
# Vérifier la syntaxe des fichiers de config
named-checkconf
# → aucune sortie = pas d'erreur

# Redémarrer BIND9
systemctl restart bind9
systemctl enable bind9
systemctl status bind9

# Si restart bind9 ne marche pas
systemctl restart named
systemctl enable named
systemctl status named
```

---

## 🔷 PHASE 2 — Réseau GSB (vmbr1, IP fixe)

> **Toutes les installations sont terminées.** Bascule sur le réseau GSB.

---

## 4. Bascule réseau vers vmbr1

### 4.1 Dans Proxmox

Modifier la carte réseau de la VM : `vmbr0` → **`vmbr1`**

### 4.2 Modifier `/etc/network/interfaces`

```bash
nano /etc/network/interfaces
```

```
# /etc/network/interfaces
# DNS-LINUX — PHASE 2 : Production (Réseau GSB)

auto lo
iface lo inet loopback

auto ens18
iface ens18 inet static
    address     172.16.0.11         # ← à définir avec le groupe
    netmask     255.255.128.0
    gateway     172.16.127.254
    dns-nameservers 172.16.0.105 172.16.0.106
    dns-search  gsb.local
```

### 4.3 Modifier `/etc/resolv.conf`

```bash
nano /etc/resolv.conf
```

```
domain gsb.local
search gsb.local
nameserver 172.16.0.105
nameserver 172.16.0.106
```

### 4.4 Appliquer et vérifier

```bash
systemctl restart networking

ip addr show ens18
# → doit afficher 172.16.0.11/17

ping -c 3 172.16.127.254    # passerelle
ping -c 3 172.16.0.105      # LABANNU1
```

---

## 5. Autorisation du transfert de zone sur LABANNU1

> À faire  sur le serveur Windows AD LABANNU1.

### 5.1 Autoriser le transfert de zone vers DNS-LINUX

Sur LABANNU1 (Windows Server), dans le **Gestionnaire DNS** :

1. Clic droit sur la zone `gsb.local` → **Propriétés**
2. Onglet **Transferts de zone**
3. Cocher **Autoriser les transferts de zone**
4. Sélectionner **Uniquement vers les serveurs répertoriés ici**
5. Ajouter l'IP de DNS-LINUX : `172.16.0.11`
6. Valider

### 5.2 Activer les notifications NOTIFY

Toujours dans les propriétés de la zone `gsb.local` :

1. Onglet **Transferts de zone** → bouton **Notifier**
2. Cocher **Notifier automatiquement**
3. Ajouter l'IP `172.16.0.11` (DNS-LINUX)
4. Valider

### 5.3 Ouvrir le port TCP 53 sur le pare-feu Windows

Sur LABANNU1, dans le **Pare-feu Windows** :

```powershell
# À exécuter en PowerShell administrateur sur LABANNU1
New-NetFirewallRule -DisplayName "DNS Zone Transfer to DNS-LINUX" `
  -Direction Inbound `
  -Protocol TCP `
  -LocalPort 53 `
  -RemoteAddress 172.16.0.11 `
  -Action Allow
```

> Les requêtes DNS classiques (UDP 53) sont déjà autorisées par défaut sur un AD Windows.

---

## 6. Vérification du transfert de zone

### 6.1 Déclencher un transfert manuellement

```bash
# Depuis DNS-LINUX — forcer le transfert de zone
rndc refresh gsb.local

# Vérifier les logs BIND9 en temps réel
journalctl -u named -f
# → chercher : "transfer of 'gsb.local' from 172.16.0.105#53: Transfer completed"
```

### 6.2 Vérifier que le fichier de zone a été créé

```bash
ls -lh /var/cache/bind/
# → gsb.local.slave doit apparaître avec une taille non nulle

# Lire le contenu de la zone téléchargée
cat /var/cache/bind/gsb.local.slave
```

### 6.3 Forcer un transfert AXFR depuis la ligne de commande

```bash
# Simuler un transfert AXFR depuis LABANNU1 vers DNS-LINUX
dig @172.16.0.105 gsb.local AXFR
# → doit lister tous les enregistrements de la zone
```

---

## 7. Tests de validation

### 7.1 Résolution directe (nom → IP)

```bash
# Tester depuis DNS-LINUX lui-même
dig @localhost gsb.local
# → doit retourner l'IP de GSB

dig @localhost labannu1.gsb.local
# → doit retourner 172.16.0.105

# Tester depuis un autre poste du réseau GSB
dig @172.16.0.11 gsb.local
```

### 7.2 Résolution inverse (IP → nom)

```bash
dig @localhost -x 172.16.0.105
# → doit retourner labannu1.gsb.local
```

### 7.3 Résolution externe (forwarder)

```bash
# BIND9 doit pouvoir résoudre des noms externes via les forwarders
dig @localhost google.com
# → doit retourner une IP publique
```

### 7.4 Vérifier la synchronisation avec LABANNU1

```bash
# Comparer le numéro de série de la zone entre maître et esclave
dig @172.16.0.105 gsb.local SOA   # numéro de série sur LABANNU1
dig @172.16.0.11   gsb.local SOA   # numéro de série sur DNS-LINUX

# → les deux numéros de série doivent être identiques
```

### 7.5 Tester la tolérance à la panne

```bash
# Simuler l'indisponibilité de LABANNU1 :
# Bloquer temporairement le port 53 vers LABANNU1 sur UFW
ufw insert 1 deny out to 172.16.0.105 port 53

# Tester que DNS-LINUX répond toujours aux requêtes (depuis la zone en cache)
dig @172.16.0.11 gsb.local
# → doit toujours fonctionner (zone en cache local)

# Rétablir la règle
ufw delete 1
```

### 7.6 Surveillance des logs

```bash
# Logs en temps réel
journalctl -u named -f

# Chercher les transferts de zone réussis
journalctl -u named | grep "Transfer completed"

# Chercher les erreurs
journalctl -u named | grep -E "(error|failed|denied)"
```

---

## 8. Tableau récapitulatif des ports

| Port | Protocole | Usage                                          |
|------|-----------|------------------------------------------------|
| 53   | UDP       | Requêtes DNS clients → DNS-LINUX               |
| 53   | TCP       | Transfert de zone LABANNU1 → DNS-LINUX (AXFR)  |
| 53   | TCP       | Requêtes DNS > 512 octets (EDNS)               |
| 22   | TCP       | Administration SSH                             |

---

## Annexe — Commandes utiles BIND9

```bash
# Statut du service
systemctl status named

# Recharger la config sans redémarrer
rndc reload

# Forcer le rafraîchissement d'une zone
rndc refresh gsb.local

# Vider le cache DNS
rndc flush

# Vérifier la syntaxe de tous les fichiers de config
named-checkconf

# Vérifier une zone spécifique
named-checkzone gsb.local /var/cache/bind/gsb.local.slave

# Voir les stats BIND9
rndc stats && cat /var/run/named/named.stats

# Tester la résolution en spécifiant le serveur
dig @172.16.0.X messagelab.gsb.local A
nslookup messagelab.gsb.local 172.16.0.X
```

---

*Document réalisé dans le cadre du projet GSB — BTS SIO option SISR*  
*DNS maître : LABANNU1 Windows AD (172.16.0.105)
*DNS secondaire Linux : BIND9
