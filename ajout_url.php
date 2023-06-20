<?php
function chercher_nom_dev($page)
{
	 $ref1="<title>";
 $ref2=" Apps on the";
 $res1 = explode($ref1 , $page);
 
  
  $res2=explode($ref2,$res1[1]);
  $taille=strlen($res2[0])-3;
  $nom_dev=substr($res2[0],3,$taille);
  return($nom_dev);
}
function get_url()
{
	$url=$_POST['url'];
	
	return $url;
}
function enregistrer_url($url,$cnx)
{

	//enregstrer les url a suivre 
	
	$req=$cnx->prepare('select url from developpeur_jeux where url=:url');
	$req->bindparam('url',$url);
	$req->execute();
	$row=$req->fetch();
	
	
		if($row['url']==$url)
		{
			
			echo"<html> <head> <title> liste</title> <link rel=\"stylesheet\" href=\"accuiel.css\" /></head><body>
			<p> l'url est deja enregstrer dans la base.</p></body></html>";
		}
	
	else
	{
		
		$page1 = file_get_contents($url);
		
       $nom_dev=chercher_nom_dev($page1);
	   $req1=$cnx->prepare('insert into developpeur_jeux(url,nom_dev)values(:url,:nom_dev)');
	   $req1->bindparam('url',$url);
	   $req1->bindparam('nom_dev',$nom_dev);
	   $req1->execute();
	   
	   echo "<html> <head> <title> liste</title> <link rel=\"stylesheet\" href=\"accuiel.css\" /></head><body>bien enregstrer.</body></html>";
	}
	
}
$cnx=new PDO('mysql:host=localhost; dbname=jeux','root','');
$url_dev=get_url();
    $ch="https://itunes.apple.com/us/developer/";
	if(preg_match("#$ch#",$url_dev,$match,PREG_OFFSET_CAPTURE)==0)
	{
		echo"<html> <head> <title> liste</title> <link rel=\"stylesheet\" href=\"accuiel.css\" /></head><body> <p> erreur.. url incorect</p></body></html>";
	}
	else 
	{
enregistrer_url($url_dev,$cnx);
	}
?>