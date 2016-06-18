<?php

require_once 'appKernel.php';

use Symfony\Component\Form;

if (!isset($_SESSION['user'])) {
    $user = new Utilisateur();
    $formSignIn = $formFactory->createBuilder('\Recipy\Form\SignInType',$user)
        ->setAction('signin.php')
        ->getForm();

    $formSignIn->handleRequest($request);

    if ($formSignIn->isValid()) {
        initSession($request, $session, $user);
        if ($request->isXmlHttpRequest()) {
            exit(json_encode(['location' => '/account.php']));
        }
        header('Location: account.php');
    }

    $formViewSignIn = $formSignIn->createView();

    $twig->addGlobal('form_sign_in', $formViewSignIn);

    if ($request->getRequestUri() == '/'. basename(__FILE__)){
        if($request->isXmlHttpRequest()) {
            exit(json_encode(['body' => $twig->render('form/modal_signin.html.twig'), 'fail' => $formSignIn]));
        } else {
            header('Location: index.php');
            exit();
        }
    }
}
