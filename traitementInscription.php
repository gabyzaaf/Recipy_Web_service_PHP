<?php
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 08/03/2016
 * Time: 15:05
 */
require_once('class/utilisateur.php');


/*
 *  Err = 1 is if a credential is false
 *
 * */
if(empty($_POST['name']) ||empty($_POST['lastname']) || empty($_POST['login']) || empty($_POST['email']) || empty($_POST['email2']) || empty($_POST['born']) || empty($_POST['mdp']) || empty($_POST['mdp2'])){
    header('Location: inscription.php?err=1');
}
/*
 *  Err = 2 the email 1 and email 2 is not identic
 *  Err = 3 the pass 1 and the pass 2 is not identic
 * */

if($_POST['email']!=$_POST['email2']){
    header('Location: inscription.php?err=2');
}else if($_POST['mdp']!=$_POST['mdp2']){
    header('Location: inscription.php?err=3');
}else{

    $userObject = new Utilisateur(NULL,$_POST['name'],$_POST['lastname'],$_POST['login'],$_POST['email'],NULL,$_POST['born'],$_POST['mdp'],NULL);

    $arruser = $userObject->exist();

    if($arruser[0]['nb']=="0"){

        if($userObject->createUser()){
            /*
             *  OK = the user is created
             * */
            header('Location: index.php?ok=1');
        }else{
            /*
             * Err = 5 the user don't was create
             *
             * */
            header('Location: inscription.php?err=5');
        }
    }else{
        /*
         * The User are already created
         *
         * */
        header('Location: inscription.php?err=4');
    }
}











?>