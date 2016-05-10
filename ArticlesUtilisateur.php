<?php
require_once("class/Recette.php");
session_start();
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 03/03/2016
 * Time: 18:36
 */
if(empty($_SESSION)){
    session_destroy();
    header('Location: index.php?err=1');
}

$recette = new Recette(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);


$var = $recette->getRecette($_SESSION['id']);

?>

<html>
    <head>


    </head>
    <body>
    <?php require_once('menu/menu.php')?>
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
                <fieldset>
                    <legend><?php echo $var[$i]["title"];?></legend>
                    <table>
                        <tr>
                            <td>contenu</td>
                            <td><?php echo $var[$i]["contenu"];?></td>
                        </tr>

                    </table>
                </fieldset>

                <?php
            }
                ?>
    <?php
        }

    ?>


    </body>

</html>
