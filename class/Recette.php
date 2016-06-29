<?php

ini_set('display_errors', 1);
require_once("pdo.php");

class Recette{

private $id;
private $autreId;
private $titre;
private $contenu;
private $image;
private $visible;
private $partage;
private $type;
private $fid;

public function __construct($id=NULL,$titre=NULL,$contenu=NULL,$image=NULL,$visible=NULL,$partage=NULL,$type=NULL,$fid=NULL)
{
	$this->id = $id;
	$this->titre = $titre;
	$this->contenu = $contenu;
	$this->image = $image;
	$this->visible = $visible;
	$this->partage = $partage;
	$this->type = $type;
	$this->fid = $fid;

}


public function creation($idUtilisateur){
	$sql = "insert into Recette(title,contenu,image_lien,visible,partage,fid) values (:title,:contenu,:image_lien,:visible,:partage,:fid)";
	$array = array(
			":title"=>$this->titre,
			":contenu"=>$this->contenu,
			":image_lien"=>$this->image,
			":visible"=>$this->visible,
			":partage"=>$this->partage,
			":fid"=>$idUtilisateur
		);
	return Spdo::getInstance()->query($sql,$array);
}

public function getRecette($idUtilisateur){
	$sql = "select * from Recette where fid=:fid and visible=1";
	$tabRecette="";
	$array = array(
			":fid"=>$idUtilisateur
		);
	
	return Spdo::getInstance()->query($sql,$array);
}

public function getRecetteInfo($idUtilisateur, $title){
	$sql = "select * from Recette where fid=:fid and visible=1 and title=:title";
	$tabRecette="";
	$array = array(
			":title"=>$title,
			":fid"=>$idUtilisateur
		);
	
	return Spdo::getInstance()->query($sql,$array);
}

public function getRecetteTitle($idUser, $title){
	$sql = "select * from Recette where title=:title and visible=1 and fid=:fid";
	$tabRecette="";
	$array = array(
			":fid"=>$idUser,
			":title"=>$title
		);
	
	return Spdo::getInstance()->query($sql,$array);
}

public function getRecetteExist($title, $idUtilisateur){
	$sql = "select * from Recette where title=:title and fid=:fid";
	$array = array(
			":title"=>$title,
			":fid"=>$idUtilisateur
		);
	
	return Spdo::getInstance()->query($sql,$array);
}

public function visible($idRecette){
	$sql = "update Recette set visible=0 where id=:id";
	$array = array(
		":id"=>$idRecette
		);
	return Spdo::getInstance()->query($sql,$array);
}

public function insertRecette($title, $contenu, $fileToUpload, $idUtilisateur){
	$sql = "insert into Recette(title,contenu,image_lien,visible,partage,fid) values (:title,:contenu, :image_lien, 1, 0,:fid)";
	$array = array(
			":title"=>$title,
			":contenu"=>$contenu,
			":image_lien"=>$fileToUpload,
			":fid"=>$idUtilisateur
		);
	return Spdo::getInstance()->query($sql,$array);
}

public function updateRecette($idRecette, $idUtilisateur, $title, $contenu, $fileToUpload){
	$sql = "update Recette set title = :title, contenu = :contenu, image_lien = :image, visible = 1, partage = 0, fid = :fid where id = :id;";
	$array = array(
			":id"=>$idRecette,
			":title"=>$title,
			":contenu"=>$contenu,
			":image"=>$fileToUpload,
			":fid"=>$idUtilisateur
		);
	return Spdo::getInstance()->query($sql,$array);
}

public function updateRecetteNoPicture($idRecette, $idUtilisateur, $title, $contenu){
	$sql = "update Recette set title = :title, contenu = :contenu, visible = 1, partage = 0, fid = :fid where id = :id;";
	$array = array(
			":id"=>$idRecette,
			":title"=>$title,
			":contenu"=>$contenu,
			":fid"=>$idUtilisateur
		);
	return Spdo::getInstance()->query($sql,$array);
}

public function deleteRecette($idUtilisateur, $title){
	$sql = "delete from Recette where title = :title and fid = :fid";
	$array = array(
			":title"=>$title,
			":fid"=>$idUtilisateur
		);
	return Spdo::getInstance()->query($sql,$array);
}
}


?>