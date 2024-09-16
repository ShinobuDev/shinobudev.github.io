# Ateliers Pratiques

<h1><ins>AP n°1</ins></h1>

<h2>Exo 1: ls</h2>

- format condensé = sans argument :

```# ls ...```

- format long = avec :

```# ls -l ...```

- affichés les fichier cachés :

```# ls -a ...```

- colorer les types de fichier :

```# ls --color ...```

- afficher en ordre inverse :

```# ls -r ...```

- un format long et en affichant les fichiers cachés, mais du plus récent au
plus ancien :

```# ls -l -a -t```

- un format long et en affichant les fichiers cachés, mais du plus ancien au
plus récent

```# ls -l -a -rt```

<h2>Exo 2: cd (sans paramètre)</h2>

- renvoie vers le dossier de l'utilisateur

<h2>Exo 3: créer plusieurs fichiers en une commande</h2>

- pour créer des fichiers :

```# touch ... ... ...```

- pour créer des dossiers :

```# mkdir ... ... ...```

<h2>Exo 4: déplacer des fichiers dans un dossier</h2>

- déplacer plusieurs fichiers dans un dossier :

```# mv [FICHIER]... ... ... ... ... [DOSSIER]...```

<h2>Exo 5: astuces</h2>

- on ne peut pas supprimer un dossier non-vide

- créer un dossier et des sous-dossier en une seule commande :

```# mkdir [PARENT]... [ENFANT][PARENT]/... [PARENT]/...```

- pour renommer un fichier, un dossier ou un dossier avec un/des fichier à l'intérieur :

```# mv [DOSSIER]... [RENOMMAGE]...```

- Copiez un fichier de votre choix du répertoire /bin dans le répertoire test/tp1
de votre dossier personnel :
  - 1. En faisant la copie depuis le répertoire /bin

       ```# cp exemple /home/test/tp1```
  - 2. En faisant la copie depuis le répertoire test/tp1

       ```# cp /bin/exemple```
  - 3. Effacez à l'aide d'une seule commande les répertoires test/tp1 et
    test/tp2

       ```# rm -Rf test```

  <h1><ins>AP n°2</ins></h1>

<h2>Exo 1: déterminez les commandes permettant de réaliser les actions suivantes</h2>

- Déterminer le répertoire par défaut dans la hiérarchie des répertoires ?
  
  ```# cd```
- Y a t-il des fichiers, des répertoires dans ce répertoire ?
  
  ```Oui il y a des fichiers et répertoire caché```
- Entrer du texte dans un fichier nommé « Mon_fichier » que vous avez créé au
préalable.

  ```# nano Mon_fichier```
- Lister le contenu de « Mon_fichier ».
  
  ```# cat Mon_fichier```
- Lister le répertoire courant.
  
  ```# ls```
- Lister les répertoires /bin et /dev.
  
  ```# ls /bin /dev```
- Créer sous votre répertoire deux sous-répertoires : « Source » et « Data ».
  
  ```# mkdir Source Data```
- Se positionner sous « Source ».
  
  ```# cd Source```
- Listez le répertoire courant.
  
  ```# ls```
- Revenir sous le répertoire de départ et détruire « Source ».
  
  ```# rm -d ../Source```
- Créer un deuxième fichier nommé « Mon_fichier_2 ».
  
  ```# touch Mon_fichier_2``` 
- Copier chaque fichier en nom_de_fichier.old.
  
  ```# cp Mon_fichier Mon_fichier.old && cp Mon_fichier2 Mon_fichier2.old```
- Créer un répertoire « Old ».

  ```# mkdir Old```
- Déplacer les fichiers avec l'extension .old vers le répertoire « Old ».

  ```mv *.old Old```
- Effacer tous les fichiers crées dans Old sans effacer le répertoire Old.

  ```# rm Old/*```

<h2>Exo 2: exploration de l'arborescence Linux : ls, cp, mv, rm, cd, pwd, mkdir, rmdir</h2>

- Indiquez par une commande dans quel répertoire vous vous trouvez.

  ```# pwd```
- Allez dans le répertoire /usr/share/doc, puis vérifiez le chemin de votre répertoire
courant.

  ```# cd /usr/share/doc && pwd```
- Remonter dans le répertoire parent puis vérifier.

  ```# cd .. && pwd*```
- Allez dans votre répertoire personnel sans taper son chemin.

  ```# cd```
- Retournez dans votre répertoire précédent sans taper son chemin.

  ```# cd ..```
- Retourner dans votre répertoire personnel et listez les fichiers présents.

  ```# ls ~```
- Listez maintenant tous les fichiers (même ceux cachés).

  ```# ls -a```
- Affichez de façon détaillée le contenu du répertoire /usr sans changer le répertoire de
travail.

  ```# ls -l -a /usr```
- Affichez l'arborescence de fichiers contenue dans /var sans changer le répertoire de
travail.

  ```# ls -l -a /var```
- Affichez de façon détaillée le contenu du répertoire /var/log en classant les fichiers du
plus vieux au plus récent.

  ```# ls -l -a /var/log```



