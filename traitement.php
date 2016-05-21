<?php

require_once 'vendor/autoload.php';
require_once 'class/utilisateur.php';

session_start();

if ((empty($_POST['login'])) || (empty($_POST['pass']))) {
    header('Location: index.php?err=1');
    exit();
} else {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $user = new Utilisateur(null, null, null, $login, null, 1, null, $pass, 0);
    //$arrayUser = $user->getConnexion();


    $_SESSION['user']['id'] = $arrayUser[0]['id'];
    $_SESSION['user']['login'] = $arrayUser[0]['logins'];
    $_SESSION['user']['nom'] = $arrayUser[0]['nom'];
    $_SESSION['user']['admin'] = $arrayUser[0]['admin'];
    $_SESSION['user']['prenom'] = $arrayUser[0]['prenom'];
    $_SESSION['user']['email'] = $arrayUser[0]['email'];
    $hashValue = sha1($_POST['login'] . "" . $_POST['pass']);

    $val = $user->checkingToken($_SESSION['user']['id']);


    $user->setToken($hashValue);
    // now create the token
    /*
     *  ERR = 8 is when you can't connect the user
     *
     * */
    if (($user->activeSession($_SESSION['user']['id'])) == false) {
        header('Location: index.php?err=8');
        exit();
    }
    $_SESSION['token'] = $hashValue;
    if ($_SESSION['user']['admin'] == true) {
        header('Location: index.php?err=8');
        exit();
    }

    header('Location: account.php');exit();
}
