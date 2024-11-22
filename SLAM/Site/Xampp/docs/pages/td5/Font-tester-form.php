<form>
    <label for="message">Message</label><br>
    <input type="text" id="message" name="message"><br>
    <label for="size">taille</label><br>
    <input type="number" id="size" name="size"><br>
    <label for="color">couleur</label><br>
    <input type="text" id="color" name="color"><br><br>
    <input type="submit">
</form>
<span style="color:<?=$_GET['color']??'black'?>; font-size:<?=$_GET['size']??'12'?>"</span>
<div><?=$_GET['message']??"message par défaut";?></div>