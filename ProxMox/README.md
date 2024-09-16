# Installation VM ProxMox

<h1><ins>Créer la VM</ins></h1>

- Cliquer sur le bouton __Créer une VM__ :

![Creer](../ProxMox/Images/Creer.png)

<h2>Système d'exploitation</h2>

- Utiliser une image de média (ISO)
- - debian-12.5.0-amd64-netinst.iso

![Systemedex](../ProxMox/Images/Systemedex.png)

<h2>Système</h2>

- Laisser par défaut

<h2>Disques</h2>

- Bus/périphérique:
- - VirtIO Block

![Disques](../ProxMox/Images/Disques.png)

<h2>Processeur</h2>

- Coeur :
- - choisir entre 1 et 3 coeur

![Processeur](../ProxMox/Images/Processeur.png)

<h2>Mémoire</h2>

- Laisser par défaut

<h2>Réseau</h2>

- Laisser par défaut

<h2>Confirmer/h2>

<h1><ins>Installer Debian</ins></h1>

<h2>Choisir la langue</h2>

- Ici nous installerons Debian en français.

![langue](../ProxMox/Installation/Langue.png)

<h2>Choisir la localisation</h2>

- Ici nous installerons Debian en France.

![Localisation](../ProxMox/Installation/Geo.png)

<h2>Choisir le language du clavier</h2>

- Le clavier que nous utiliserons sera français et donc AZERTY. 

![Clavier](../ProxMox/Installation/Clavier.png)

<h2>Choisir le nom de la machine</h2>

- Mettez un nom de machine commencant par "debian" et finissant par vos initiaux, notez que le nom de la machine et vos initiaux sont séparés par un tiret.

![nommachine](../ProxMox/Installation/nommachine.png)

<h2>Choisir le domaine</h2>

- Laisser par défaut.

![Domaine](../ProxMox/Installation/domaine.png)

<h2>Choisir le mot de passe du duper utilisateur (root)</h2>

- Prenez un mot de passe facile pour le mot de passe du super utilisateur.

![root](../ProxMox/Installation/mdpsuperu.png)

<h2>Choisir le login de l'utilisateur par défaut</h2>

- Mettez votre prénom en nom d'utilisateur par défaut.

![user](../ProxMox/Installation/loginuser.png)

<h2>Choisir le mot de passe de l'utilisateur par défaut</h2>

- Choisissez un mot de passe dont vous vous souviendrez.

![mdpuser](../ProxMox/Installation/mdpuser.png)

<h2>Choisir le/les disques où installer Debian</h2>

- Utilisez un disque entier.

![Disques](../ProxMox/Installation/Disques.png)

<h2>Schéma de partitionnement</h2>

- Choisissez le schéma de partitionnement : "Partitions /home, /var et /tmp séparées

![partition](../ProxMox/Installation/partition.png)

<h2>Appliquer les changements sur le/les disques</h2>

- Cliquez sur oui.

![OUI](../ProxMox/Installation/OUI.png)

<h2>Analyser les supports d'installation</h2>

- Cliquez sur non.

![NON](../ProxMox/Installation/NON.png)

<h2>Choisir le pays du miroir de l'archive Debian</h2>

- Dans ce cas nous choisirons la France car c'est le pays le plus proche.

![Gestionpaquets](../ProxMox/Installation/Gestionpaquets.png)

<h2>Choisir le miroir de l'archive Debian</h2>

- Cliquez sur le premier ou le deuxième (c'est la même chose).

![Gestionpaquets2](../ProxMox/Installation/Gestionpaquets2.png)

<h2>Participer à l'étude statistique sur l'utilisation des paquets</h2>

- Cliquez sur non.

![Stats](../ProxMox/Installation/Stats.png)

<h2>Logiciels à installer</h2>

- Décocher environnement de bureau Debian et Gnome. Cocher Serveur SSH et utilitaires usuels du système.
- - note : Utilisez la touche <ins>ESPACE</ins> pour cocher et décocher pas <ins>ENTREE</ins>.

![Logiciels](../ProxMox/Installation/Logiciels.png)

<h2>Installer le programme de démarrage GRUB sur le disque principal</h2>

- Cliquez sur oui.

![GRUB](../ProxMox/Installation/GRUB.png)

<h2>Choisir le périphérique où sera installé le programme de démarrage</h2>

- Choisir /dev/vda.

![GRUBPC](../ProxMox/Installation/GRUBPC.png)

<h2>Redémmarrer après l'installation</h2>

- Cliquez sur continuer ou attendre 15 secondes.

![redemarrage](../ProxMox/Installation/redemarrage.png)

<h1>C'est terminer !</h1>

![terminer](../ProxMox/Installation/terminer.png)
