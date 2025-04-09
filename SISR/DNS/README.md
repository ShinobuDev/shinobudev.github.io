# 🛰️ Configuration d’un Serveur DNS primaire et secondaire + Reverse DNS avec BIND9  
📦 *Compatible & testé avec Debian 12.5 (Bookworm)*

---

# 📚 Sommaire

1. [🎯 Prérequis](#🎯-prérequis)  
2. [📁 Particularités Debian 12.5](#📁-particularités-debian-125)  
3. [🧱 Installation de BIND9](#🧱-1-installation-de-bind9)  
4. [🗂️ Création des zones DNS](#🗂️-2-création-des-zones-dns)  
5. [📄 Création des fichiers de zone](#📄-3-création-des-fichiers-de-zone)  
   - [Fichier de zone direct](#Fichier-de-zone-direct)
   - [Fichier de zone inverse](#Fichier-de-zone-inverse)
6. [✅ Vérification des fichiers de configuration](#✅-4-vérification-des-fichiers-de-configuration)  
7. [🔄 Rechargement et redémarrage du service](#🔄-5-redémarrage-ou-rechargement-du-service)  
8. [🧪 Tester la résolution DNS](#🧪-6-tester-la-résolution-dns)  
9. [⚙️ Définir le serveur DNS local](#⚙️-7-définir-le-serveur-dns-local)  
10. [⛔ Empêcher la réécriture de resolv.conf](#⛔-8-empêcher-la-réécriture-de-etcresolvconf)  
11. [🛰️ Configuration d’un serveur DNS secondaire (slave)](#🛰️-9-configuration-dun-serveur-dns-secondaire-esclave)  
    - [Configuration du maître](#configuration-du-maitre)  
    - [Configuration de l’esclave](#configuration-de-lesclave)
    - [Vérifications](#verifications)

---

## 🎯 Prérequis <a id="🎯-prérequis"></a>

Avant de commencer, assure-toi que :

- Tu disposes d’un accès `root` ou `sudo`.
- Ton serveur a une IP statique sur ton réseau local (ex : `192.168.1.18`).

---

## 📁 Particularités Debian 12.5 <a id="📁-particularités-debian-125"></a>

| Élément                      | Détail                                                                 |
|-----------------------------|------------------------------------------------------------------------|
| 📂 Fichiers de zones         | Ils **doivent être placés** dans `/var/cache/bind/`                  |
| 🔗 `/etc/resolv.conf`       | Souvent un lien symbolique géré automatiquement par `systemd-resolved` |

---

## 🧱 1. Installation de BIND9 <a id="🧱-1-installation-de-bind9"></a>

```bash
sudo apt update
sudo apt install bind9
```

### ✅ Vérification du statut

```bash
systemctl status bind9
```

---

## 🗂️ 2. Création des zones DNS <a id="🗂️-2-création-des-zones-dns"></a>

### Modifier le fichier : `/etc/bind/named.conf.local`

```bash
sudo nano /etc/bind/named.conf.local
```

➡️ Ajouter à la fin du fichier :

```conf
zone "@.local" {
    type master;
    file "db.@.local";
};

zone "1.168.192.in-addr.arpa" {
    type master;
    file "db.192.168.1";
};
```

> 🔁 Remplace **@** par ton nom de domaine personnalisé (ex. `monsite`, `reseau`, etc.).

---

## 📄 3. Création des fichiers de zone <a id="📄-3-création-des-fichiers-de-zone"></a>

### 🧭 Fichier de zone **direct** : `/var/cache/bind/db.@.local` <a id="Fichier-de-zone-direct"></a>

```bash
sudo nano /var/cache/bind/db.@.local
```

➡️ Contenu :

```dns
$TTL 604800

@.local.    IN    SOA    debianDNS.@.local.    admin.@.local.    (
              2         ; Serial
         604800         ; Refresh
          86400         ; Retry
        2419200         ; Expire
         604800         ; Negative Cache TTL
)

; Name server
@.local.       IN  NS  debianDNS.@.local.

; Host addresses
debianDNS.@.local.      IN    A    192.168.1.18
poste01.@.local.        IN    A    192.168.1.188
```

> 🔁 Remplace `@` par ton nom de domaine.  
> 🔁 Remplace **`debianDNS`** par le nom de ton serveur DNS (ex. `dns01`).  
> ⚠️ Utilise **soit des tabulations, soit des espaces**, mais pas les deux.

---

### 🔁 Fichier de zone **inverse** : `/var/cache/bind/db.192.168.1` <a id="Fichier-de-zone-inverse"></a>

```bash
sudo nano /var/cache/bind/db.192.168.1
```

➡️ Contenu :

```dns
$TTL 86400

1.168.192.in-addr.arpa.    IN    SOA    debianDNS.@.local.    admin.@.local.    (
              1         ; Serial
         604800         ; Refresh
          86400         ; Retry
        2419200         ; Expire
          86400         ; Negative Cache TTL
)

; Name server
1.168.192.in-addr.arpa.       IN    NS    debianDNS.@.local.

; PTR records
18.168.192.in-addr.arpa.      IN    PTR   debianDNS.@.local.
188.168.192.in-addr.arpa.     IN    PTR   poste01.@.local.
```

> 🔁 Ici aussi, remplace `@` et `debianDNS` comme ci-dessus.

## ✅ 4. Vérification des fichiers de configuration <a id="✅-4-vérification-des-fichiers-de-configuration"></a>

```bash
sudo named-checkconf -z
```

> ✅ Si aucun message d’erreur n’apparaît, tout est bon.

---

## 🔄 5. Redémarrage ou rechargement du service <a id="🔄-5-redémarrage-ou-rechargement-du-service"></a>

### Après modification d’un `.conf` :

```bash
sudo systemctl restart bind9
```

### Après modification d’un fichier de zone :

```bash
sudo systemctl reload bind9
```

### Vérifier que le service est actif :

```bash
systemctl status bind9
```

---

## 🧪 6. Tester la résolution DNS <a id="🧪-6-tester-la-résolution-dns"></a>

### Résolution **directe** :

```bash
dig debianDNS.@.local
```

### Résolution **inverse** :

```bash
dig -x 192.168.1.18
dig -x 192.168.1.188
```

> ✔️ Si la réponse contient :  
`;; ->>HEADER<<- opcode: QUERY, status: NOERROR`  
et une section **ANSWER** avec 1 ou plusieurs résultats → 🎉 **ça fonctionne !**

---

## ⚙️ 7. Définir le serveur DNS local <a id="⚙️-7-définir-le-serveur-dns-local"></a>

### Modifier `/etc/resolv.conf` :

```bash
sudo nano /etc/resolv.conf
```

➡️ Exemple de contenu :

```
domain @.local
search @.local
nameserver 127.0.0.1
```

> 🔁 Remplace `@` par ton domaine.

---

## ⛔ 8. Empêcher la réécriture de `/etc/resolv.conf` <a id="⛔-8-empêcher-la-réécriture-de-etcresolvconf"></a>

### 1. Trouver le processus DHCP :

```bash
ps -aux | grep dhcp
```

### 2. Terminer le processus `dhclient` :

```bash
sudo kill <PID>
```

> Remplace `<PID>` par le numéro du processus trouvé précédemment.

---

## 🛰️ 9. Configuration d’un serveur DNS secondaire (esclave) <a id="🛰️-9-configuration-dun-serveur-dns-secondaire-esclave"></a>

🎯 Le serveur secondaire va **répliquer automatiquement** les zones depuis le maître.

---

### 🧱 Sur le **serveur primaire (master)** <a id="configuration-du-maitre"></a>

#### 🔧 Modifier `/etc/bind/named.conf.local` pour autoriser le DNS secondaire :

```conf
zone "@.local" {
    type master;
    file "db.@.local";
    allow-transfer { 192.168.1.19; }; // IP du serveur secondaire
};

zone "1.168.192.in-addr.arpa" {
    type master;
    file "db.192.168.1";
    allow-transfer { 192.168.1.19; }; // IP du serveur secondaire
};
```

> 🔁 Remplace `@` par ton domaine et `192.168.1.19` par l’IP de ton serveur secondaire.

🔄 Puis redémarre BIND9 :

```bash
sudo systemctl restart bind9
```

---

### 🧱 Sur le **serveur secondaire (slave)** <a id="configuration-de-lesclave"></a>

#### 1. Installer BIND9 comme sur le serveur secondaire :

```bash
sudo apt update
sudo apt install bind9
```

---

#### 2. Créer les zones secondaires dans `/etc/bind/named.conf.local` :

```bash
sudo nano /etc/bind/named.conf.local
```

➡️ Ajouter :

```conf
zone "@.local" {
    type slave;
    masters { 192.168.1.18; };  // IP du serveur maître
    file "/var/cache/bind/slave.db.@.local";
};

zone "1.168.192.in-addr.arpa" {
    type slave;
    masters { 192.168.1.18; };
    file "/var/cache/bind/slave.db.192.168.1";
};
```

> 🔁 Remplace `@` par ton domaine.  
> 🔁 `192.168.1.18` est l’IP du serveur primaire (master).  
> Les fichiers seront générés automatiquement dans `/var/cache/bind/`.

---

#### 3. Redémarrer le service BIND9 sur le slave

```bash
sudo systemctl restart bind9
```

---

### ✅ Vérification <a id="verifications"></a>

Sur le **serveur secondaire**, vérifie que les fichiers sont bien récupérés :

```bash
ls /var/cache/bind/
```

Tu dois y voir :

- `slave.db.@.local`
- `slave.db.192.168.1`

Puis teste avec `dig` :

```bash
dig @192.168.1.19 debianDNS.@.local
dig @192.168.1.19 -x 192.168.1.18
```
