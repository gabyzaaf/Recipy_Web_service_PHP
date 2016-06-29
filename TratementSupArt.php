<?php
require_once('class/Recette.php');
session_start();

$idUser = $_SESSION['id'];
$title = $_POST['title'];

if(empty($_POST['title'])){
    header('Location: SupprimerArticle.php?err=1');
}else if(empty($_POST)){
    header('Location: index.php?err=1');
}else{
	$recette = new Recette();
	$tableau = $recette->getRecetteTitle($idUser, $title);
	for ($i=0;$i<count($tableau);$i++)
	{
		//unlink($tableau[$i]["image_lien"]);
		$recette->deleteRecette($idUser, $title);
		echo "suppression effectué";
		header("refresh:2;url=SupprimerArticle.php");
	}
}


?>
