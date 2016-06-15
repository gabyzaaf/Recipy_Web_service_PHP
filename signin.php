<?php

require_once 'appKernel.php';

use Symfony\Component\Form as Form;
if(!isset($_SESSION['user'])) {

    $formSignIn = $formFactory->createBuilder('\Recipy\Form\SignInType')
        ->getForm();

    $formSignIn->handleRequest($request);

    if ($formSignIn->isSubmitted() && $formSignIn->isValid()) {
        exit(json_encode(['location' => '/account.php']));
    }

    $formViewSignIn = $formSignIn->createView();

    $twig->addGlobal('form_sign_in', $formViewSignIn);
}