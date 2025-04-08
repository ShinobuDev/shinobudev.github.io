# 🛰️ Configuration d’un Serveur DNS + Reverse DNS avec BIND9  
📦 *Compatible & testé avec Debian 12.5 (Bookworm)*

---

## 🎯 Prérequis

Avant de commencer, assure-toi que :

- Tu disposes d’un accès `root` ou `sudo`.
- Ton serveur a une IP statique sur ton réseau local (ex : `192.168.1.18`).

---

## 📁 Particularités Debian 12.5

| Élément                      | Détail                                                                 |
|-----------------------------|------------------------------------------------------------------------|
| 📂 Fichiers de zones         | Ils **doivent être placés** dans `/var/cache/bind/`                  |
| 🔗 `/etc/resolv.conf`       | Souvent un lien symbolique géré automatiquement par `systemd-resolved` |

---

## 🧱 1. Installation de BIND9

```bash
sudo apt update
sudo apt install bind9
```

### ✅ Vérification du statut

```bash
systemctl status bind9
```

---

## 🗂️ 2. Création des zones DNS

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

## 📄 3. Création des fichiers de zone

### 🧭 Fichier de zone **direct** : `/var/cache/bind/db.@.local`

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

### 🔁 Fichier de zone **inverse** : `/var/cache/bind/db.192.168.1`

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

## ✅ 4. Vérification des fichiers de configuration

```bash
sudo named-checkconf -z
```

> ✅ Si aucun message d’erreur n’apparaît, tout est bon.

---

## 🔄 5. Redémarrage ou rechargement du service

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

## 🧪 6. Tester la résolution DNS

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

## ⚙️ 7. Définir le serveur DNS local

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

## ⛔ 8. Empêcher la réécriture de `/etc/resolv.conf`

### 1. Trouver le processus DHCP :

```bash
ps -aux | grep dhcp
```

### 2. Terminer le processus `dhclient` :

```bash
sudo kill <PID>
```

> Remplace `<PID>` par le numéro du processus trouvé précédemment.
