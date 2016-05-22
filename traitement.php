<?php

include_once 'appKernel.php';


if ((empty($_POST['login'])) || (empty($_POST['pass']))) {
    header('Location: index.php?err=1');
    exit();
} else {
    $login = $request->request->get('login');
    $pass = $request->request->get('pass');
    $user = new Utilisateur(null, null, null, $login, null, 1, null, $pass, 0);
    $arrayUser = $user->getConnexion();

    if (empty($arrayUser)) {
        header('Location: index.php?err=1');
        exit();
    }

    $userData = reset($arrayUser);

    $_SESSION['user']['id'] = $userData['id'];
    $_SESSION['user']['login'] = $userData['logins'];
    $_SESSION['user']['nom'] = $userData['nom'];
    $_SESSION['user']['admin'] = $userData['admin'];
    $_SESSION['user']['prenom'] = $userData['prenom'];
    $_SESSION['user']['email'] = $userData['email'];
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
    $_SESSION['user']['token'] = $hashValue;
    if ($_SESSION['user']['admin'] == true) {
        header('Location: index.php?err=8');
        exit();
    }
    header('Location: account.php');
    exit();
}
