<?php

require_once 'appKernel.php';

use Symfony\Component\Form as Form;

if (!isset($_SESSION['user'])) {

    $formSignUp = $formFactory->createBuilder('\Recipy\Form\SignUpType', new Utilisateur())
        ->setAction('signup.php')
        ->getForm();

    $formSignUp->handleRequest($request);

    if ($formSignUp->isSubmitted() && $formSignUp->isValid()) {
        $user->createUser();
        initSession($request, $session);
        if ($request->isXmlHttpRequest()) {
            exit(json_encode(['location' => '/account.php']));
        }
        header('Location: account.php');
    }

    $formViewSignIn = $formSignUp->createView();

    $twig->addGlobal('form_sign_up', $formViewSignIn);

    if ($formSignUp->isSubmitted() && $request->isXmlHttpRequest()) {
        exit(json_encode(['body' => $twig->render('form/modal_signup.html.twig'), 'fail' => $formSignUp]));
    }

    if ($request->getRequestUri() == '/'. basename(__FILE__)) {
        if ($formSignUp->isSubmitted()) {
            exit(json_encode(['body' => $twig->render('form/modal_signup.html.twig'), 'fail' => $formSignUp]));
        } else {
            header('Location: index.php');
        }
    }
}

