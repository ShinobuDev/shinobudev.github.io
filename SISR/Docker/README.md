# 🐳 Exploitation Avancée de Docker sous Linux

📦 *Compatible Debian 12.5 & distributions basées sur Debian*

---

## 📚 Sommaire

1. [🔧 Prérequis & Environnement](#1)
2. [🔍 Inspection des Réseaux Docker](#2)
3. [🌐 Création d’un Réseau Docker Personnalisé](#3)
4. [📡 Connexion des Conteneurs à un Réseau](#4)
5. [🔁 Connexion d’un Conteneur à Plusieurs Réseaux](#5)
6. [📤 Communication entre Conteneurs](#6)
7. [🧯 Suppression de Réseaux](#7)
8. [📦 Utilisation des Volumes Docker](#8)
9. [🚀 Tests & Commandes Complètes](#9)

---

<a name="1"></a>

## 🔧 1. Prérequis & Environnement

Avant toute manipulation :

```bash
sudo apt update
sudo apt install docker.io -y
sudo systemctl start docker
sudo systemctl enable docker
```

> ⚠️ Tous les exemples ci-dessous supposent que Docker est installé et fonctionnel sur votre machine.

---

<a name="2"></a>

## 🔍 2. Inspection des Réseaux Docker

Lister tous les réseaux existants :

```bash
docker network ls
```

Inspecter un réseau par défaut (`bridge`, `host`, ou `none`) :

```bash
docker network inspect bridge
```

---

<a name="3"></a>

## 🌐 3. Création d’un Réseau Docker Personnalisé

Créer un réseau de type **bridge** personnalisé :

```bash
docker network create --driver bridge monreseau
```

Vérifier la création :

```bash
docker network ls
```

Inspecter le réseau :

```bash
docker network inspect monreseau
```

---

<a name="4"></a>

## 📡 4. Connexion des Conteneurs à un Réseau

Créer un conteneur en le connectant directement à un réseau spécifique :

```bash
docker run -dit --name conteneur1 --network monreseau debian
```

Tester sa connectivité :

```bash
docker exec -it conteneur1 bash
apt update && apt install iputils-ping -y
ping conteneur1
```

---

<a name="5"></a>

## 🔁 5. Connexion d’un Conteneur à Plusieurs Réseaux

Créer un second réseau :

```bash
docker network create secondreseau
```

Créer un second conteneur :

```bash
docker run -dit --name conteneur2 --network secondreseau debian
```

Puis connecter ce conteneur au premier réseau :

```bash
docker network connect monreseau conteneur2
```

Maintenant, `conteneur2` est connecté à **deux réseaux**.

---

<a name="6"></a>

## 📤 6. Communication entre Conteneurs

Tester la communication inter-conteneurs :

```bash
docker exec -it conteneur1 bash
ping conteneur2
```

> 🎯 Les conteneurs sur un même réseau Docker peuvent se pinguer par **nom de conteneur**.

---

<a name="7"></a>

## 🧯 7. Suppression de Réseaux

⚠️ Un réseau ne peut pas être supprimé tant qu’un conteneur y est encore connecté.

Déconnecter un conteneur :

```bash
docker network disconnect monreseau conteneur1
```

Supprimer un réseau :

```bash
docker network rm monreseau
```

---

<a name="8"></a>

## 📦 8. Utilisation des Volumes Docker

Créer un volume :

```bash
docker volume create monvolume
```

Créer un conteneur avec ce volume monté :

```bash
docker run -dit --name conteneur3 -v monvolume:/data debian
```

Vérifier l’existence du volume :

```bash
docker volume ls
docker volume inspect monvolume
```

---

<a name="9"></a>

## 🚀 9. Tests & Commandes Complètes

Voici un script de test complet pour tout vérifier :

```bash
# Création des réseaux
docker network create netA
docker network create netB

# Création des conteneurs
docker run -dit --name test1 --network netA debian
docker run -dit --name test2 --network netB debian

# Connexion multiple
docker network connect netA test2

# Ping entre conteneurs
docker exec -it test1 bash
apt update && apt install iputils-ping -y
ping test2

# Gestion de volumes
docker volume create testvol
docker run -dit --name voltest -v testvol:/app debian
```
