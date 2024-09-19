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

<h2>Exo 3: répertoires et consultation de fichiers</h2>

- Allez dans votre répertoire personnel.

   ```# cd```
- Créez un répertoire portant le nom de CommandesLinux.

   ```# mkdir CommandesLinux```
- Allez dans le dossier CommandesLinux et créez les répertoires suivants

   ```# mkdir CommandesLinux/Code CommandesLinux/Code/couleur CommandesLinux/Code/forme CommandesLinux/Code/couleur/froide CommandesLinux/Code/forme/angle CommandesLinux/Code/forme/courbe```
- Copiez le fichier /etc/services dans votre répertoire CommandesLinux.

   ```# cp /etc/services CommandesLinux```
- À qui appartient le fichier que vous venez de copier ? Quelle est sa date de sa dernière
modification ?
   - il appartient a ```root```
   - sa dernière date de modification est ```16 sept. 14.00```
- Créez les fichiers ne contenant aucune donnée et dont les noms sont les suivants :
rond.txt, triangle.txt, carre.txt, rectangle.txt, vert.txt et bleu.txt

   ```touch rond.txt triangle.txt carre.txt rectangle.txt vert.txt bleu.txt```
- Déplacez le fichier rond.txt dans le répertoire courbe et les fichiers triangle.txt,
carre.txt, rectangle.txt dans le répertoire angle.

   ```# mv rond.txt Code/forme/courbe```
   ```# mv triangle.txt rectangle.txt carre.txt Code/forme/angle ```
  
- Déplacez les fichiers vert.txt et bleu.txt dans le répertoire froide.

   ```# mv vert.txt bleu.txt Code/couleur/froide```
- Allez dans le répertoire couleur et afficher le contenu du répertoire de façon récursive.

   ```# cd Code/couleur/froide```
   ```# ls -R```
- Copier le répertoire sous le nom chaude. Est-ce possible ? Comment ?

   ```# cd ..```
   ```# cp -r froide chaude```
- Allez dans le répertoire chaude et renommez le fichier bleu.txt en rouge.txt et vert.txt
en jaune.txt.

   ```# cd chaude```
   ```# mv bleu.txt rouge.txt && mv vert.txt jaune.txt```
- Remontez dans le répertoire CommandesLinux et renommez le répertoire couleur en
peinture. Est-il besoin de spécifier une option particulière à la commande mv.

   ```# cd ../../..```
   ```#  mv Code/couleur Code/peinture```
   - non il n'y a pas besoin d'option particulière pour la commande mv dans ce cas là 
- Listez la totalité de l'arborescence contenue dans le répertoire CommandeLinux.

   ```# ls -lR```

<h1><ins>AP n°3</ins></h1>

<h2>Exo 1: répertoires</h2>

- Dans votre répertoire personnel, créez un dossier envinfo1.

   ```# mkdir envinfo1```
- En restant dans votre répertoire personnel, créez les dossiers td3 td4 td5 dans le répertoire
  envinfo1 à l’aide d’une seule commande.

   ```# mkdir envinfo1/td3 envinfo1/td4 envinfo1/td5```
- Déplacez-vous dans le répertoire envinfo1.

   ```# cd envinfo1```
- Créez les répertoires td6 td7 td8 à l’aide d’une seule commande.

   ```# mkdir td6 td7 td8```
   ```# tree```
- Quelle(s) différence(s) faites-vous entre ces deux commandes pour créer les répertoires ?

   - pour la première commande je dois utiliser un chemin absolut alors que pour la deuxième commande je dois             utiliser le répertoire 
- En restant dans le répertoire envinfo1, créez en une seule commande un dossier eval, lui-
  même contenant qcm1 et qcm2.

   ```# mkdir eval eval/qcm1 eval/qcm2```

<h2>Exo 2: arborescence et chemins</h2>

À la suite de l’exercice précédent, vous vous trouvez toujours dans le répertoire envinfo1.

- Déplacez-vous dans le répertoire qcm1 en une seule commande.

   ```# cd eval/qcm1```
- Utilisez la commande cd sans paramètre. Où vous retrouvez-vous ?

   ```# cd```
   - Je me trouve dans le dossier personnel

- Déplacez-vous dans le répertoire qcm1. Avez-vous tapé la même commande qu’à la
première question de cet exercice ? Pourquoi ?

   ```# cd envinfo1/eval/qcm1```
   - non car je n'étais pas dans le dossier personnel

- Allez dans le répertoire « grand-parent » de qcm1 (donc dans le répertoire envinfo1).
Donnez le chemin relatif par rapport au répertoire où vous vous trouvez (qcm1) et
donnez le chemin absolu pour vous rendre dans ce répertoire.
   - chemin relatif

   ```# cd ../../```
   - chemin absolu

   ```# cd root/envinfo1```
- Donnez la commande pour trouver le chemin absolu de votre répertoire personnel.
Quel est ce chemin ?

   ```# cd /home```
- Pour vous déplacer dans le répertoire eval donnez les chemins absolus (à partir de la
racine puis à partir de votre répertoire personnel) et le chemin relatif.
   - racine
     - racine absolu

     ```# cd /root/envinfo1/eval```
     - racine relatif

     ```# cd /eval```
   - personnel
     - racine absolu

     ```# cd /home```
     - racine relatif

     ```# cd ../../home```

<h2>Exo 3: fichiers et répertoires</h2>

À la suite de l’exercice précédent, vous vous trouvez toujours dans le répertoire eval.
- Créez les fichiers vides controle1.txt, controle2.txt et controle3.txt en une seule
  commande.

   ```# touch controle1.txt controle2.txt controle3.txt```
- Créez le répertoire controles

   ```# mkdir controles```
- Renommez le répertoire controles en examens

   ```# mv controles examens```
- Déplacer les fichiers controle1.txt, controle2.txt et controle3.txt dans le répertoire
  examens.

   ```# mv controle1.txt controle2.txt controle3.txt examens/```
- Déplacez-vous dans le répertoire examens puis copiez tous les fichiers dans le répertoire
  qcm1.

   ```#  cp controle1.txt controle2.txt controle3.txt ../qcm1```
- Déplacez-vous dans le répertoire qcm1 et créez en une seule commande les fichiers
  question1.txt, question2.txt et question3.txt.

   ```# touch question1.txt question2.txt question3.txt```

<h2>Exo 4: suppression de répertoires et de fichiers</h2>

À la suite de l’exercice précédent, vous vous trouvez dans le répertoire qcm1.

- Essayer d’effacer le répertoire examens à l’aide de la commande rmdir. Pourquoi cela ne
  fonctionne pas ?

   ```# rmdir ../examens```

   - car le répertoire n'est pas vide
- Supprimer le répertoire qcm2.

   ```# rmdir ../qcm2```
- Déplacer-vous dans le dossier envinfo1. En une seule commande. Dupliquez le répertoire
  qcm1 et tout ce qu’il contient sous le nom qcm2.

   ```# cd ../..```
   ```# cp -r eval/qcm1 eval/qcm2```
- Déplacez-vous dans le répertoire qcm2.

   ```# cd eval/qcm2```
- Supprimez tous les fichiers dont le nom commence par controle (utilisez pour cela un «
  joker »).

   ```# rm controle*.txt```
- Créez le fichier caché reponses.txt.

   ```# touch .reponses.txt```
- Affichez l’ensemble des fichiers du répertoire qcm2 avec les fichiers cachés et en format
  long.

   ```# ld -l -a```
- Supprimez le dossier qcm1 et tout ce qu’il contient en une seule commande.

   ```# rm -Rf ../qcm1```

<h2>Exo5: joker</h2>

A la suite de l’exercice précédent vous vous trouvez dans le répertoire qcm2.
- Dans le répertoire eval créez les fichiers suivants : qcm1.txt Qcm2.doc QCm3.txt et
  QCM4.doc.

   ```# touch ../qcm1.txt ../Qcm2.doc ../QCm3.txt ../QCM4.doc```
- Affichez tous les fichiers de eval dont le nom commence par la lettre Q majuscule.

   ```# tree ../Q*```
- Affichez les noms de fichiers donc la troisième lettre est un M majuscule.

   ```# tree ../**M*```
- Affichez les noms de fichiers qui se terminent par l’extension .txt

   ```# tree ../*.txt```
- Supprimez tous les fichiers que vous avez créés lors de la première question de cet
  exercice en essayant de spécifier le moins d’arguments possible.

   ```# rm ../*.*```

<h2>Exo 6: pour conclure, on utilise un peu tout</h2>

A la suite de l’exercice précédent vous vous trouvez dans le répertoire eval.
- Déplacez-vous dans le répertoire qcm2.

   ```# cd qcm2```
- Sans changer de répertoire, affichez uniquement les dossiers td4, td5, td6, td7 et td8. Pour
  réaliser cette opération, utilisez une seule commande et un seul argument

   ```# tree  ../../td*```
- Supprimez les dossiers td4, td5, td6, td7 et td8. Pour réaliser cette suppression, utilisez la
  commande précédente sans la retaper.

   ```# rm -d  ../../td*```
- A l’aide de la commande ls, affichez l’ensemble des répertoires, des sous-répertoires et des
  fichiers du répertoire envinfo1 (sans changer de répertoire courant). Cet affichage devra être
  réalisé en format long et avec les fichiers cachés. Vous utiliserez un chemin absolu et un
  chemin relatif. Utilisez aussi la commande tree pour visualiser l’arborescence.
   - chemin absolu
  
   ```# ls -R -l -a /root/envinfo1```
   - chemin relatif
  
   ```# ls -R -l -a ../../..```
- Allez dans la corbeille. Pouvez-vous récupérer les répertoires et fichiers que vous avez
  supprimés avec les commandes précédentes.
   - pas de corbeille ????
  
   ```# ```
- Allez dans votre dossier personnel, supprimer le répertoire envinfo1

   ```cd ~/```
   ```rm -r envinfo1/```




