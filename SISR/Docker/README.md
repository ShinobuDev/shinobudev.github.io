# 🐳 Guide Avancé Docker sous Linux — Partie 1/2

📘 *Basé sur Debian 11.x, compatible Debian 12.5*

---

## 📌 Sommaire

1. [🎯 Objectifs du TP](#0)
3. [🐋 1. Installation de Docker](#1)
4. [📦 2. Lancer un conteneur Ubuntu interactif](#2)
5. [🧱 3ème Partie : Création d'une image personnalisée)](#3)
6. [🔐 4ème Partie : Rendre un service accessible depuis l’extérieur](#4)

---

## 🎯 Objectifs du TP <a id="0"></a>

Ce TP vise à te rendre autonome sur :

* Le déploiement d’une machine Debian 11.x
* L’installation complète de Docker
* Le lancement d’un conteneur Ubuntu en mode interactif
* La gestion de services via Docker

---

## 🐋 1. Installation de Docker <a id="1"></a>

Docker n’est pas présent par défaut dans les dépôts de base de Debian. Voici comment l’ajouter proprement :

### a) Préparation de l’environnement

```bash
sudo apt update
sudo apt install apt-transport-https ca-certificates curl gnupg2 software-properties-common
```

### b) Ajout de la clé GPG officielle de Docker

```bash
curl -fsSL https://download.docker.com/linux/$(. /etc/os-release; echo "$ID")/gpg | sudo apt-key add -
```
> La variable ≪ $(. /etc/os-release; echo "$ID") ≫ renvoie la distribution. Attention à l’espace
  entre ≪ / ≫ et le ≪ . ≫ et de meme entre ≪ add ≫ et ≪ - ≫.

### c) Ajout du dépôt Docker

```bash
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/$(. /etc/os-release; echo "$ID") $(lsb_release -cs) stable"
```

### d) Mise à jour des dépôts et installation

```bash
sudo apt update
sudo apt install docker-ce
```

### e) Activer Docker au démarrage

```bash
sudo systemctl enable docker
```

### f) Vérifier l’installation

```bash
docker version
```

### g) Tester Docker avec le conteneur de test officiel

```bash
docker run hello-world
```

> 🟢 Si tout se passe bien, Docker affiche un message de bienvenue.

---

## 📦 2. Lancer un conteneur Ubuntu interactif <a id="2"></a>

Tu peux maintenant lancer un conteneur Ubuntu pour y exécuter des commandes :

### 🔄 a) Commande de lancement :

```bash
docker run --name serveurUbuntu -it ubuntu
```

### Explication des options :

| Option   | Description                                     |
| -------- | ----------------------------------------------- |
| `--name` | Nomme le conteneur pour le retrouver facilement |
| `-i`     | Active l’entrée standard interactive (stdin)    |
| `-t`     | Fournit un pseudo-terminal (tty)                |

> 🧑‍💻 Tu te retrouves dans un shell Ubuntu **dans le conteneur**.

---

### 🔄 b) Mettre à jour le système et y installer le service ssh :

```bash
apt update
apt install openssh-server
```
> On va créer également un utilisateur pour pouvoir se connecter au service ultérieurement.
  ```bash
  adduser « votre nom de user »
  ```

---

### 🔄 c) Arrêter un conteneur

Pour arrêter un conteneur en cours d’exécution de manière interactive, il suffit de taper :

```bash
exit
```

Cela termine la session interactive et arrête le conteneur.

---

### 🔁 d) Relancer un conteneur existant

Pour redémarrer le conteneur précédemment arrêté et y accéder de nouveau en mode interactif :

```bash
docker start serveurUbuntu
docker attach serveurUbuntu
```
> 💻 Il faut lancer un **PuTTY** pour utiliser l'image Docker ET pouvoir faire un commande docker top.


---

### 🧾 e) Visualiser les modifications apportées au conteneur

Pour inspecter les différences entre l’image d’origine et les modifications réalisées dans le conteneur :

```bash
docker diff serveurUbuntu
```

Cette commande affiche les fichiers modifiés, ajoutés ou supprimés à l'intérieur du conteneur.

---

### 📊 f) Lister les processus actifs dans le conteneur

Pour voir tous les processus en cours d’exécution à l’intérieur du conteneur :

```bash
docker top serveurUbuntu
```

> 💡 Si le service SSH est activé dans le conteneur, vous le verrez listé dans les processus.

---

## 🧱 3ème Partie : Création d'une image personnalisée <a id="3"></a>

### 📦 a) Créer une nouvelle image à partir du conteneur actif

```bash
docker commit serveurUbuntu ubuntu:ssh
```

Cela crée une nouvelle image basée sur l’état actuel du conteneur.

Pour vérifier que l’image a bien été créée :

```bash
docker images
```

---

## 🔐 4ème Partie : Rendre un service accessible depuis l’extérieur <a id="4"></a>

### 🚀 a) Lancer un conteneur SSH en arrière-plan avec mappage de port

Crée un nouveau conteneur basé sur l’image personnalisée `ubuntu:ssh` avec SSH actif, et mappe le port 22222 de l’hôte vers le port 22 du conteneur :

```bash
docker run -d -p @IPMachineHôte:22222:22 --name serveurssh ubuntu:ssh /usr/sbin/sshd -D
```

#### 🧩 Explication des options :

* `-d` : exécute le conteneur en **mode détaché** (arrière-plan).
* `-p` : réalise le **mappage de ports** `hôte:conteneur`.
* `@IPMachineHôte` : adresse IP de l'hôte (à remplacer).
* `22222` : port ouvert sur l'hôte.
* `22` : port SSH dans le conteneur.
* `/usr/sbin/sshd -D` : lance le service SSH en **premier plan** (Docker arrête un conteneur si le processus principal se termine).

> 📌 Remarque :
>
> * Si tu omets l’adresse IP de l’hôte, Docker n’écoutera que sur `localhost`.
> * Si tu omets le port de l’hôte, Docker choisira un port aléatoire disponible.

### 🔍 Vérifier que tout fonctionne :

```bash
docker ps
```

Regarde la colonne **PORTS** pour t'assurer que le mappage `@IPMachineHôte:22222->22/tcp` est bien en place.

---

### 🔗 b) Se connecter au conteneur en SSH

Une fois que le conteneur `serveurssh` tourne, tu peux te connecter depuis n’importe quelle machine sur le réseau.

#### ✅ Exemple sous Linux :

```bash
ssh user@@IPMachineHôte -p 22222
```

> 🔁 Remplace `user` par un utilisateur valide dans le conteneur, user a été créer [ici](#ici).
> 🔁 Remplace `@IPMachineHôte` par l’IP de la machine qui héberge Docker

#### ❌ Déconnexion :

```bash
exit
```

---

#### 🪟 Exemple sous Windows :

Sous Windows, utilise un client SSH comme [PuTTY](https://www.putty.org/) :

* Adresse IP : `@IPMachineHôte`
* Port : `22222`
* Protocole : `SSH`

Clique sur **"Open"** pour établir la connexion.

---

### 📜 c) Afficher les logs du conteneur

Pour consulter les journaux du conteneur `serveurssh` :

```bash
docker logs serveurssh
```

> 📭 Si tout fonctionne normalement, cette commande ne renverra **aucune sortie**.
