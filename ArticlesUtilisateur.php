<?php
require_once("class/Recette.php");
session_start();
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 03/03/2016
 * Time: 18:36
 */
if(empty($_SESSION['user'])){
    session_destroy();
    header('Location: index.php?err=1');
}

$recette = new Recette(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$var = $recette->getRecette($_SESSION['user']["id"]);

?>

<html>
    <head>


    </head>
    <body>
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

        </table>
    </fieldset>
    <?php
        if(empty($var)){
            ?>
            <fieldset>
                <legend>Articles</legend>
            <table>
                <tr>
                    <td>Aucun article est present</td>
                </tr>
            </table>
            </fieldset>
    <?php
        }else{
            for($i=0;$i<count($var);$i++) {
                ?>
                <table>
                    <tr>
                        <td>title</td>
                        <td><?php echo $var[$i]["title"];?></td>
                    </tr>
                    <tr>
                        <td>contenu</td>
                        <td><?php echo $var[$i]["contenu"];?></td>
                    </tr>

                </table>
                <?php
            }
                ?>
    <?php
        }

    ?>


    </body>

</html>
