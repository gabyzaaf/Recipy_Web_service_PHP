<?php

session_start();
require_once("class/Recette.php");

?>
<html>

<head>
	<script language = "javascript">
	
		function chercherRecette($mRecette) {
			var xhr_object = null; 	    
			if(window.XMLHttpRequest) // Firefox 
				xhr_object = new XMLHttpRequest(); 
			else if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
					alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
					return; 
				}   
			//traitement à la réception des données
		   xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4 && xhr_object.status == 200) { 
				 var formulaire = document.getElementById("formRecette");
				formulaire.innerHTML=xhr_object.responseText;} 
		   }
		   //communication vers le serveur
		   xhr_object.open("POST", "chercheRecette.php", true); 
		   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		   var data = "titreRecette=" + $mRecette ;
		   xhr_object.send(data); 
	   }
		
	</script>
</head>


<body>
<center>
<fieldset>
    <legend>Menu</legend>
    <table border="1">
        <tr >
            <td><a href="profiUtilisateur.php">informations</a></td>
            <td><a href="ArticlesUtilisateur.php">Consulter ses articles</a></td>
			<td><a href="RechercherArticle.php">Rechercher Article</a></td>
        </tr>
        <tr>
            <td><a href="CreeArticle.php">Creer un nouvel article</a></td>
			<td><a href="ModifierArticle.php">Modifier un article</a></td>
			<td><a href="SupprimerArticle.php">Supprimer un article</a></td>
        </tr>

    </table>
</fieldset>
</center>
<center>
    <fieldset>
        <legend>Modifier votre article</legend>
        <table>
            <tr>
                <td>Title de l'article</td>
            </tr>
            <tr>
                <td>
					<select name="titreRecette" onchange="chercherRecette(this.value);">
						<option selected="selected" disabled="disabled">---Choisir une recette---</option>
						<?php
						$value = 2;
						$recette = new Recette();
						$tableau = $recette->getRecette($_SESSION['id']);

						for ($i=0;$i<count($tableau);$i++)
						{
							?>
							<option value="<?php echo $tableau[$i]['title']; ?>"> <?php echo $tableau[$i]['title']; ?></option>
							<?php
						}

						?>
					</select>
				</td>
            </tr>
        </table>
    </fieldset>
	<br>
	<div id="formRecette"></div>
</center>
<script src="verification.js"></script>
</body>


</html>

