<?php
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 03/03/2016
 * Time: 20:39
 */
session_start();
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
        <legend>Ecrire votre article</legend>
    <form enctype="multipart/form-data" method="post" onsubmit="return mySubmitFunction()" action="TratementArticles.php">
        <table>
            <tr>
                <td>Title de l'article</td>
            </tr>
            <tr>
                <td><input type="text" style="width: 300px;" name="title" ></td>
            </tr>
            <tr>
                <td>Contenu de l'article</td>
            </tr>
            <tr>
                <td><textarea rows="10" cols="50" name="content" ></textarea></td>
            </tr>
            <tr>
                <td>Image</td>
            </tr>
            <tr>
                <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
            </tr>
            <tr>
                <td><input type="submit" value="creer article"></td>
            </tr>
        </table>

    </form>
    </fieldset>
</center>
<script src="verification.js"></script>
</body>


</html>

