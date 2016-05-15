<?php

require_once 'vendor/autoload.php';
require_once 'class/utilisateur.php';

session_start();
$loader = new Twig_Loader_Filesystem('./views/');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension( new Twig_Extension_Debug());
$twig->addExtension( new Recipy\Extension\Twig\User());

if((empty($_POST['login'])) || (empty($_POST['pass']))){
    header('Location: index.php?err=1');
    exit();
}else{
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $user = new Utilisateur(NULL,NULL,NULL,$login,NULL,1,NULL,$pass,0);
    //$arrayUser = $user->getConnexion();




    $_SESSION['id'] = $arrayUser[0]['id'];
    $_SESSION['login'] = $arrayUser[0]['logins'];
    $_SESSION['nom'] = $arrayUser[0]['nom'];
    $_SESSION['admin'] = $arrayUser[0]['admin'];
    $_SESSION['prenom'] = $arrayUser[0]['prenom'];
    $_SESSION['email'] = $arrayUser[0]['email'];
    $hashValue = sha1($_POST['login']."".$_POST['pass']);

    $val = $user->checkingToken($_SESSION['id']);


    $user->setToken($hashValue);
    // now create the token
    /*
     *  ERR = 8 is when you can't connect the user
     *
     * */
    if(($user->activeSession($_SESSION['id']))==false){
        header('Location: index.php?err=8');
    }
    $_SESSION['Token']=$hashValue;
    if($_SESSION['admin']==True){
        header('Location: index.php?err=8');
    }
}
?>

<html>
    <head>
        <style>
            fieldset
            {
                background-color:#CCC;
                max-width:500px;
                padding:16px;
            }
            .legend1
            {
                margin-bottom:0px;
                margin-left:16px;
                text-align:center;
            }
        </style>
    </head>


    <body>
   <?php
    require_once('menu/menu.php');
   ?>