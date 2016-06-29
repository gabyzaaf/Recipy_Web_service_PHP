<?php 
session_start();
require_once("class/Recette.php");

$idUser = $_SESSION['id'];
$_SESSION['Title'] = $_POST['titreRecette'];
$recette = new Recette();
$tableau = $recette->getRecetteTitle($idUser, $_POST['titreRecette']);


	for ($i=0;$i<count($tableau);$i++)
	{	
		echo '
		<fieldset>
        <legend>Information de la recette</legend>
		<form enctype="multipart/form-data" method="post" onsubmit="return mySubmitFunction()" action="TratementModRec.php">
		<table>
		<tr>
			<td>Titre :</td>
		</tr>
		<tr>
			<td><input name="title" value="'.$tableau[$i]["title"].'"></td>
		</tr>
		<tr>
			<td>Contenu :</td>
		</tr>
		<tr>
			<td><textarea size="150" name="contenu" >'.$tableau[$i]["contenu"].'</textarea></td>
		</tr>
		<tr>
			<td>Image lien :</td>
		</tr>
		<tr>
			<td><input type="file" name="fileToUpload" id="fileToUpload" value="'.$tableau[$i]["image_lien"].'">'.$tableau[$i]["image_lien"].'</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><input type="submit" value="modifier la recette"></td>
		</tr>
		</form>
		</table>
		</fieldset>';
	}	

?>

