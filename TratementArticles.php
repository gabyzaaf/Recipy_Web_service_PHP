<?php
require_once('class/Recette.php');
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 03/03/2016
 * Time: 21:39
 */

session_start();

if(empty($_POST['title']) || empty($_POST['content'])){
    header('Location: CreeArticle.php?err=1');
}else if(empty($_POST)){
    header('Location: index.php?err=1');
}else{

}


?>