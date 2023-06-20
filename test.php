
<?php
function select_dev($cnx)
{
	$req=$cnx->prepare('select * from developpeur_jeux');
	$req->execute();
	$j=0;
	 $liste= array();
	while($row=$req->fetch()) 
	{
		 
		$page1 = file_get_contents($row['url']);
		
		
  $nom_dev=$row['nom_dev'];
  $code_dev=choix_code_dev($nom_dev,$cnx);
$ch="iPhoneiPadApps\":{\"data\":\[{\"type\":\"lockup/app\",\"id\":\"";
$ch1="\]";
preg_match("#$ch#",$page1,$match,PREG_OFFSET_CAPTURE);
$page=substr($page1,$match[0][1]-strlen($page1)+25);
preg_match("#$ch1#",$page,$match1,PREG_OFFSET_CAPTURE);

$page=substr($page,0,$match1[0][1]);

 $ar=json_decode("[".$page."]");
 
 $ref1="<title>";
 $ref2="</title>";
 $supp=" on the App Store";
 $l=strlen($supp);

for($i=0;$i<count($ar);$i++)
{
	
	$urlt=concat_url($ar[$i]->id);
	$page_de_jeu=file_get_contents($urlt);
	$res1 = explode($ref1 , $page_de_jeu);
	 
	 
	  $res2=explode($ref2,$res1[1]);
	 $longeur_nom= strlen($res2[0])-$l;
	 $nom_jeu=substr($res2[0],3,$longeur_nom-3);
      
$liste[$j]=$nom_jeu;
 $j=$j+1;  
	modif_tableau($nom_jeu,$ar[$i]->id,$cnx,$nom_dev,$code_dev);
		
	}
	
	
}
supprime($liste,$cnx);
} 
///////////////////////////////////////////////////////////////////////
function choix_code_dev($nom_dev,$cnx)
{
   $req=$cnx->prepare('select * from liste where nom_dev=:nom_dev');
   $req->bindparam('nom_dev',$nom_dev);
   $req->execute();
   
   if($row=$req->fetch())
   {
	   $code=$row['code_dev'];
   }
   else
   {
	   $code=rand();
   }
   return($code);
   
}
//////////////////////////////////////////////////////////////////////////////
function concat_url($id)
{
	$url="https://itunes.apple.com/us/app/id";
$urlt=$url.$id;
return $urlt;
}
//////////////////////////////////////////////////////////////////////////////////
function modif_tableau($nom_jeu,$id,$cnx,$nom_dev,$code)
{
	
	$req=$cnx->prepare('SELECT nom_jeu from liste where nom_jeu=:nom_jeu');
		$req->bindparam('nom_jeu',$nom_jeu);
		
		$req->execute();
		$row=$req->fetch();
		
	
		
			if($nom_jeu!=$row['nom_jeu'])
			{
			  //enrigstrer le nom de jeu dans la base
		  
	     echo " <html> <head> <title> liste</title> <link rel=\"stylesheet\" href=\"accuiel.css\" /></head><body>".$nom_jeu."est un nouveau jeu enregstrer dans la base<br></body></html>";
		 $req1=$cnx->prepare('insert into liste(nom_jeu,code_jeu,date_ajout,nom_dev,code_dev)values(:nj,:cj,now(),:n_dev,:c_dev)');
		 $req1->bindparam('nj',$nom_jeu);
		 $req1->bindparam('cj',$id);
		 $req1->bindparam('n_dev',$nom_dev);
		$req1->bindparam('c_dev',$code);
		 $req1->execute();
			
			}
		
			
			
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function supprime($liste,$cnx)
{
	
	$req=$cnx->prepare('select nom_jeu from liste');
	$req->execute();
	while($row=$req->fetch())
	{
		if (!in_array($row['nom_jeu'],$liste))
		{
		 echo "<html> <head> <title> liste</title> <link rel=\"stylesheet\" href=\"accuiel.css\" /></head><body>".$row['nom_jeu']." est supprimer!!<br></body></html>";	
			$req1=$cnx->prepare('delete from liste where nom_jeu= :nj');
			$req1->bindparam('nj',$row['nom_jeu']);
			$req1->execute();
		}
		
	}
	
}



$cnx=new PDO('mysql:host=localhost; dbname=jeux','root','');
select_dev($cnx);




		
		 





		 
?>