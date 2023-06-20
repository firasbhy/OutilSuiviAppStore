<?php
$cnx=new PDO('mysql:host=localhost; dbname=jeux','root','');
$dev=$_POST['choix'];
if($dev!='*')
{
$req=$cnx->prepare('select * from liste where nom_dev=:dev');
$req->bindparam('dev',$dev);
$req->execute();
echo"<html> <head> <title> liste</title> <link rel=\"stylesheet\" href=\"liste.css\" /></head><body><table border=10> <tr> <td>nom de jeu</td><td>code de jeu</td>
<td>date d'ajout</td><td>nom de devloppeur</td><td>code de devloppeur</td></tr>";
while($row=$req->fetch())
{
	echo"<tr> <td>";
 echo	$row['nom_jeu']."</td> <td>".$row['code_jeu']."</td><td>".$row['date_ajout']."</td><td>".$row['nom_dev']."</td><td>".$row['code_dev']."</td></tr>";
 
}
echo" </body> </html>";
}

else 
{
	$req=$cnx->prepare('select * from liste ');
$req->bindparam('dev',$dev);
$req->execute();
echo"<html> <head> <title> liste</title> <link rel=\"stylesheet\" href=\"liste.css\" /></head><body><table border=10> <tr> <td>nom de jeu</td><td>code de jeu</td><td>date d'ajout</td><td>nom de devloppeur</td><td>code de devloppeur</td></tr>";
while($row=$req->fetch())
{
	echo"<tr> <td>";
 echo	$row['nom_jeu']."</td> <td>".$row['code_jeu']."</td><td>".$row['date_ajout']."</td><td>".$row['nom_dev']."</td><td>".$row['code_dev']."</td></tr>";
 
}
echo"</body> </html>";
}

?>