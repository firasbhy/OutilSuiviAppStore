<html>
<head>
<title>
affiche
</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="accuiel.css" />
</head>
<body>
<p>vollez vous les jeux de quel/s développeur/s???</p>
<form method="post" action="affiche.php">
<?php
$cnx=new PDO('mysql:host=localhost; dbname=jeux','root','');
$req=$cnx->prepare('select nom_dev from  developpeur_jeux');
$req->execute();
while($row=$req->fetch())
{
echo $row['nom_dev']."<input type='radio' name='choix' value='".$row['nom_dev']."'> ";
}
?>
tous les développeurs<input type="radio" name="choix" value="*">
 
<br>
<input type="submit" value="afficher" class="btn btn-primary">
</form>
</body>
</html>