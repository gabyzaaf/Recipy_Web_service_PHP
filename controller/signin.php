<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form;
use Recipy\Entity\Utilisateur;

if (!isset($_SESSION['user'])) {
    $user = new Utilisateur();
    /** @var Request $request */
    $request = $container->get('request');
    /** @var Callable $generateUri */
    $generateUri = $container->get('generate_uri');
    $action = $container->get('router')->generate('login');

    $formSignIn = $formFactory->createBuilder('\Recipy\Form\SignInType', $user)
        ->setAction($action)
        ->getForm();

    $formSignIn->handleRequest($request);

    if ($formSignIn->isValid()) {
        initSession($container, $request, $container->get('session'), $user, ['withPass' => true]);
        $location = $container->get('router')->generate('account');
        if ($request->isXmlHttpRequest()) {
            exit(json_encode(['location' => $location]));
        }
        header('Location: ' . $location);
    }

    $formViewSignIn = $formSignIn->createView();

    $twig->addGlobal('form_sign_in', $formViewSignIn);

    if ($request->getRequestUri() == '/' . basename(__FILE__)) {
        if ($request->isXmlHttpRequest()) {
            exit(json_encode(['body' => $twig->render('form/modal_signin.html.twig'), 'fail' => $formSignIn]));
        } else {
            header('Location: '.$container->get('router')->generate('index'));
            exit();
        }
    }
}
