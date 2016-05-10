<?php
require_once('class/Recette.php');
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 03/03/2016
 * Time: 21:39
 */
define ("MAX_SIZE","400");
session_start();

if(empty($_SESSION['id'])){
    session_destroy();
    /*
     * Annotation session
     * */
    header('Location: index.php?err=6');
}

if(empty($_POST['title']) || empty($_POST['content']) ){

    header('Location: CreeArticle.php?err=1');
}else if(empty($_POST)){
    header('Location: index.php?err=1');
}else{
    if(empty($_POST['title']) || empty($_POST['content']) ){

        /*
         *  All the input must be complet
         *  Err = 2
         * */
        header('Location: creeArticle.php?err=2');
    }


    $objetRecette="";
    if(!empty($_POST['file'])){
        $objetRecette = new Recette(NULL,$_POST['title'],$_POST['content'],$_FILES['file']['tmp_name'],1,1,NULL,$_SESSION['id']);

    }else{
        $objetRecette = new Recette(NULL,$_POST['title'],$_POST['content'],NULL,1,1,NULL,$_SESSION['id']);
    }
    /*
     * if its OK ok=1
     * */
    if($objetRecette->creation($_SESSION['id'])){
        header('Location: creeArticle.php?ok=1');
    }else{
        /*
         *  Err = 3  if the add is not successfull:
         * */
        header('Location: creeArticle.php?err=3');
    }


}


?>