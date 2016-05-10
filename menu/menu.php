<?php
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 08/03/2016
 * Time: 16:20
 */

if(empty($_SESSION)){
    header('Location: index.php?err=1');
}

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
            </tr>
            <tr>
                <td><a href="CreeArticle.php">Creer un nouvel article</a></td>
                <td><a href="RechercherArticle.php">Rechercher Article</a></td>
            </tr>
            <tr>
                <td><a href="disconnect.php">Deconnexion</a> </td>
            </tr>

        </table>
    </fieldset>
</center>
</body>
</html>
