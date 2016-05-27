<?php

session_start();
require_once("class/Recette.php");


?>
<html>

<head>

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
        <legend>Supprimer un article</legend>
			
    <form enctype="multipart/form-data" method="post" onsubmit="return mySubmitFunction()" action="TratementSupArt.php">
        <table>
            <tr>
                <td>Title de l'article</td>
            </tr>
            <tr>
                <td>
					<select type="text" name="title" >
						<option selected="selected" disabled="disabled">---Choisir une recette---</option>
						<?php
						$recette = new Recette();
						$tableau = $recette->getRecette($_SESSION['user']['id']);

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
            <tr>
                <td><input type="submit" value="supprimer la recette"></td>
            </tr>
        </table>
		
    </form>
    </fieldset>
</center>
<script src="verification.js"></script>
</body>


</html>

