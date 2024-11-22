<span style="color:<?=$_GET['color']??'black'?>; font-size:<?=$_GET['size']??'12'?>"</span>
<div><?=$_GET['message']??"message par défaut";?></div>

<?php
echo '<a href="Font-tester.php">test</a><br>';
echo '<a href="Font-tester.php?message=OUI&color=red&size=15">1</a><br>';
echo '<a href="Font-tester.php?message=NON&color=green&size=30">2</a><br>';
echo '<a href="Font-tester.php?message=AHAHAH&color=blue&size=50">3</a>';
?>

