<?php
require_once('class/Recette.php');
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 03/03/2016
 * Time: 21:39
 */

session_start();

$idUser = $_SESSION['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$target_dir = "uploads/";
$target_file = $target_dir .$idUser."_". basename($_FILES["fileToUpload"]["name"]);



if(empty($_POST['title']) || empty($_POST['content'])){
    header('Location: CreeArticle.php?err=1');
}else if(empty($_POST)){
    header('Location: index.php?err=1');
}else{
	
	$recette = new Recette();
	$recetteExist = $recette->getRecetteExist($title, $idUser);
	if(empty($recetteExist)){
		$target_dir = "uploads/";
		$target_file = $target_dir .$idUser."_". basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = true;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = true;
			} else {
				echo "File is not an image.";
				$uploadOk = false;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = false;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = false;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = false;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == false) {
			echo "Sorry, your file was not uploaded.";
			header("refresh:2;url=CreeArticle.php");
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ".$idUser."_". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				$recette->insertRecette($title, $content, $target_file, $idUser);
				echo "Recette ajouter";
				header("refresh:2;url=CreeArticle.php");
			}else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}else{
				echo " Cette utilisateur à déjà ajouter cette recette. ";
				header("refresh:2;url=CreeArticle.php");
			}	
	
}


?>