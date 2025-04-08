# 📡 Configuration d’un Serveur DNS avec BIND9

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
    file "/var/cache/bind/db.@.local";
};
```

> 🔁 Remplacer **@** par ton nom de domaine personnalisé.

---

## 📄 3. Création du fichier de zone

### Créer : `/var/cache/bind/db.@.local`

```bash
sudo nano /var/cache/bind/db.@.local
```

> 🔁 Remplacer **@** par ton nom de domaine personnalisé.

➡️ Contenu du fichier :

```dns
$TTL 604800

@.local.  IN  SOA  debian-AR-DNS.@.local.  admin.@.local.  (
             2         ; Serial
        604800         ; Refresh
         86400         ; Retry
       2419200         ; Expire
        604800         ; Negative Cache TTL
)

; Name servers
@.local.  IN  NS  debian-AR-DNS.@.local.

; Addresses
debian-AR-DNS.@.local   IN  A   192.168.1.1
CEQUETUVEUX.@.local     IN  A   192.168.1.10
```

> ⚠️ Attention à bien utiliser **des tabulations ou des espaces mais jamais les deux** dans le fichier.

> 🔁 Remplacer `@` par ton domaine, et `debian-AR-DNS` par le nom de ton serveur.

---

## ✅ 4. Vérification de la configuration

### Vérifie la validité des fichiers de configuration :

```bash
sudo named-checkconf
sudo named-checkzone @.local /var/cache/bind/db.@.local
```

> 🔁 Remplacer **@** par ton nom de domaine personnalisé.

> 🔧 Si des erreurs apparaissent, elles indiqueront la ligne à corriger.

---

## 🔄 5. Redémarrage ou rechargement du service DNS

### Après modification d’un `.conf` :

```bash
sudo systemctl restart bind9
```

### Après modification d’un fichier de zone uniquement :

```bash
sudo systemctl reload bind9
```

### Vérifier que le service est actif :

```bash
systemctl status bind9
```

---

## 🧪 6. Tester le serveur DNS

### Tester si on interroge bien les serveurs racines :

```bash
dig
```

---

## ⚙️ 7. Changer le DNS local utilisé

### Modifier : `/etc/resolv.conf`

```bash
sudo nano /etc/resolv.conf
```

➡️ Exemple de contenu :

```
domain @.local
search @.local
nameserver 127.0.0.1
```
> 🔁 Remplacer `@` par ton domaine, et `debian-AR-DNS` par le nom de ton serveur.

> 🔁 Remplacer par l’IP de ton serveur DNS si besoin.

---

## ⛔ Empêcher la modification automatique de `/etc/resolv.conf`

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

## 🔁 8. Tester les enregistrements DNS

### Exemple de commande `dig` :

```bash
dig debian-AR-DNS.@.local
```

> 🔁 Remplacer `@` par ton domaine, et `debian-AR-DNS` par le nom de ton serveur.

> ✔️ Si la réponse contient :
- **QUERY: 1**
- **ANSWER: 1**

alors la résolution DNS est **fonctionnelle** 🎉
