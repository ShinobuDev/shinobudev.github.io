# 📡 Configuration d’un Serveur DNS avec BIND9

## 🧱 1. Installation du paquet DNS/DHCP

```bash
sudo apt update
sudo apt install bind9
```

### ✅ Vérifier que le service BIND9 est bien actif :

```bash
systemctl status bind9
```

---

## 🗂️ 2. Création des zones DNS

### Fichier à modifier :

```bash
sudo nano /etc/bind/named.conf.local
```

> Remplace **named** par n’importe quel nom personnalisé. Par exemple : `exemple.local`

---

## 📄 3. Création du fichier de zone

Créer le fichier :

```bash
sudo nano /var/cache/bind/db.robin.local
```

**Attention :**
- Ne pas mélanger tabulations et espaces.
- Remplacer `debian-AR-DNS` par le nom de ta machine.
- Toujours adapter `robin` selon ton nom de domaine.

---

## ✅ 4. Vérification de la configuration

### Tester la syntaxe des fichiers :

```bash
sudo named-checkconf
```

> 🔧 Si une erreur s’affiche, aller à la ligne indiquée et corriger.

---

## 🔄 5. Recharger ou redémarrer le service DNS

### Si un fichier `.conf` a été modifié :

```bash
sudo systemctl restart bind9
```

### Si un fichier de zone a été modifié :

```bash
sudo systemctl reload bind9
```

### Toujours vérifier l’état du service :

```bash
systemctl status bind9
```

---

## 🧪 6. Tests de fonctionnement

### 🔍 Vérifier la résolution DNS avec DIG

```bash
dig
```

> Permet de tester si les serveurs racines sont bien contactés.

---

## 🧭 7. Modifier le DNS utilisé localement

### Éditer le fichier de configuration DNS :

```bash
sudo nano /etc/resolv.conf
```

> ⚠️ Si tu veux empêcher les modifications automatiques :

1. Rechercher le processus DHCP :

```bash
ps -aux | grep dhcp
```

2. Trouver et tuer le processus `dhclient` (remplacer `PID` par l’identifiant du processus) :

```bash
sudo kill PID
```

---

## 🔁 8. Vérifier les enregistrements DNS

### Utiliser `dig` :

```bash
dig nom_de_machine.robin.local
```

> ✔️ Si tu obtiens **1 QUERY** et **1 ANSWER**, c’est que le DNS fonctionne correctement.
