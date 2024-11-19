# Faire un serveur Apache2 sur Debian

## Avant toutes choses :

### Configurer une IP static

Modifier le fichier interfaces pour changer son IP :

![](Capture/interfaces.png)

Modifier le fichier resolv.conf pour enlever le domaine de base et le remplacer par une ip fixe :

![](Capture/resolv.png)

Relancer Debian avec la commande : ```reboot```

## 1er méthode - Installer normalement apache2

Lancer la commande : ```apt install apache2```

Une fois apache2 installé, modifier le fichier html avec ``` nano /var/www/html/index.html``` si vous le souhaitez.
(tout les sites crées avec apache2 pourrons être modifier dans ```/var/www/html/leSiteQueTuVeux```)

Mettez votre adresse IP sur votre navigateur pour y accéder.

## 2eme méthode - Faire du multisite

### 1 - Mettre en place une seconde adresse IP

Mettre sa deuxième adresse avec la commande ```ip adr add x.x.x.x/16 dev ens18 label ens18:0```
(le 16 après l'adresse IP est le CIDR, pour le masque de sous-réseau)

ens18 est l'ethernet du réseau.
Pour cette deuxième adresse nous renomons ens18 en ens18:0 pour la ne pas faire de conflit.

![](Capture/IP2.png)

On peut voir que la deuxième IP est active (première IP ```ens18```, deuxième IP ```ens18:0```)

### 2 - Mettre en place les 2 sites

Créer les fichiers des 2 sites : ```mkdir -p /var/www/html/site1 /var/www/html/site2```

Créer les 2 hôtes virtuel pour les 2
 





