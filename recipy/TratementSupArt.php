<?php
require_once('class/Recette.php');
session_start();

if(empty($_POST['title'])){
    header('Location: SupprimerArticle.php?err=1');
}else if(empty($_POST)){
    header('Location: index.php?err=1');
}else{
	$recette = new Recette();
	$tableau = $recette->getRecetteTitle($_POST['title']);
	for ($i=0;$i<count($tableau);$i++)
	{
		$idTitle = $tableau[$i]['id'];
		$recette->deleteRecette($idTitle);
	}
	
	echo "suppression effectué";
	header("refresh:2;url=SupprimerArticle.php");
}


?>
