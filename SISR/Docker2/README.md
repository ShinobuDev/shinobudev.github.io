# 🚀 TP Docker 2/2 : Déploiement d’un site Web statique et dynamique

## 📚 BTS SIO1 – SupAvenir Sainte-Ursule – Bloc 1

---

## 🧪 Activité 1 : Déploiement d’un site Web statique

### 1. Télécharger l’image Debian Bookworm

```bash
docker pull debian:bookworm
```

### 2. Lancer un conteneur nommé `serveurWebStatique`

```bash
docker run -it --name serveurWebStatique debian:bookworm bash
```

### 3. Mettre à jour les paquets

```bash
apt update
```

### 4. Mettre à jour la date système

```bash
dpkg-reconfigure tzdata
```

> Choisir Europe(8) et Paris(37)

### 5. Installer Apache2

```bash
apt install apache2
```

### 6. Créer une image `bookworm:apache2`

Dans un autre terminal :

```bash
docker commit serveurWebStatique bookworm:apache2
```

### 7. Lancer deux conteneurs `serveurWeb1` et `serveurWeb2`

```bash
docker run -d -it --name serveurWeb1 -p [ton ip]8001:80 bookworm:apache2

docker run -d -it --name serveurWeb2 -p [ton ip]8002:80 bookworm:apache2
```

### 8. Tester l’accès

Dans un navigateur :

* http://[ton ip]:8001
* http://[ton ip]:8002

---

## 🧪 Activité 2 : Déploiement d’un site Web dynamique

### 🎯 Objectif : déployer Apache2 + PHP et lier à une base MariaDB

---

## 🛠️ Travail n°1 : Installation de l’application Web

### a) Démarrer le conteneur Apache2

```bash
docker run -it --name serveurWeb bookworm:apache2 bash
```

### b) Mise à jour

```bash
apt update
```

### c) Installer PHP et les modules

```bash
apt install php8.2 php-mysql8.2
```

### d) Créer l’image `bookworm:apache2-php`

```bash
docker commit serveurWeb bookworm:apache2-php8.2
```

### e) Préparer le dossier de l’application

```bash
mkdir -p /var/www/html_docker
cp -r [vos fichiers geststages] /var/www/html_docker
```

### f) Lancer le conteneur pour accéder à geststages

```bash
docker run -dit --name serveurWeb -p [ton ip]8001:80 -v /var/www/html_docker:/var/www/html bookworm:apache2-php8.2
```

Tester sur : http://[ton ip]:8001/geststages

---

## 🛠️ Travail n°2 : Liaison avec la base de données

### a) Lancer le conteneur MariaDB

```bash
docker run -dit --name serveurbdd -e MARIADB_ROOT_PASSWORD=mdpmariadb -p [ton ip]3306:3306 -v /var/lib/mysql_docker:/var/lib/mysql mariadb
```

### b) Tester la connexion (dans un autre terminal)

```bash
apt install mariadb-client
mariadb -h [ton ip] -u root -pmdpmariadb
```

### c) Connexion via conteneur client

```bash
docker run -it --rm --link serveurbdd:clientmariadb mariadb bash -c 'exec mariadb -h "$CLIENTMARIADB_PORT_3306_TCP_ADDR" u root -pmdpmariadb'
```

### d) Initialiser la base de données

```bash
docker run -it --rm --link serveurbdd:clientmariadb -v /mnt/scripts:/scripts mariadb bash -c 'exec mariadb -h "$CLIENTMARIADB_PORT_3306_TCP_ADDR" -u root -pmdpmariadb < /scripts/geststages.sql'
```

### e) Vérifier l’importation

Dans une session cliente MariaDB :

```sql
SHOW DATABASES;
USE geststages;
SHOW TABLES;
```

### f) Supprimer le conteneur serveurWeb (précédent)

```bash
docker stop serveurWeb

docker rm serveurWeb
```

---

## 🧪 Travail n°3 : Test final de la solution

### a) Lancer `serveurWebDynamique` lié à `serveurbdd`

```bash
docker run -dit --name serveurWebDynamique --link serveurbdd:servbd -p [ton ip]8001:80 -v /var/www/html_docker:/var/www/html bookworm:apache2-php8.2
```

### b) Tester l’application

Navigateur : http://[ton ip]:8001/geststages

✅ Connexion :

* Login : `benpas01`
* Mot de passe : `benpas01`

---

## ✅ Résultat final

Les deux conteneurs `serveurWebDynamique` et `serveurbdd` sont maintenant **déployés en production**, avec persistance et modularité assurée.
