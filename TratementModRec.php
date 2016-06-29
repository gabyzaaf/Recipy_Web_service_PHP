<?php
require_once('class/Recette.php');
session_start();

$idUser = $_SESSION['id'];
$target_dir = "uploads/".$idUser."_";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);



if(empty($_POST['title'])){
    header('Location:  .php?err=1');
}else if(empty($_POST)){
    header('Location: index.php?err=1');
}else{
	$recette = new Recette();
	$tableau = $recette->getRecetteTitle($idUser, $_SESSION['Title']);
	for ($i=0;$i<count($tableau);$i++)
	{
		$idTitle = $tableau[$i]['id'];
		if($target_file == "uploads/".$idUser."_"){
			$recette->updateRecetteNoPicture($idTitle, $idUser, $_POST['title'], $_POST['contenu']);
		}else{
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
				//header("refresh:2;url=CreeArticle.php");
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					unlink($tableau[$i]["image_lien"]);
					echo "The file ".$idUser."_". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
					$recette->updateRecette($idTitle, $idUser, $_POST['title'], $_POST['contenu'], $target_file);
					echo "Recette modifier";
					//header("refresh:2;url=CreeArticle.php");
				}else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
				
			}
	}
	echo "Modification effectué";
	//header("refresh:2;url=ModifierArticle.php");
}


?>
