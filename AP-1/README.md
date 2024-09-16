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



    










