<?php
require_once('class/Recette.php');
session_start();

$idUser = $_SESSION['id'];

if(empty($_POST['title'])){
    header('Location:  .php?err=1');
}else if(empty($_POST)){
    header('Location: index.php?err=1');
}else{
	$recette = new Recette();
	$tableau = $recette->getRecetteTitle($_SESSION['Title']);
	for ($i=0;$i<count($tableau);$i++)
	{
		$idTitle = $tableau[$i]['id'];
		$recette->updateRecette($idTitle, $idUser, $_POST['title'], $_POST['contenu']);
	}
	echo "Modification effectué";
	header("refresh:2;url=ModifierArticle.php");
}


?>
