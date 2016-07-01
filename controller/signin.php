<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form;
use Recipy\Entity\Utilisateur;

if (!isset($_SESSION['user'])) {
    $user = new Utilisateur();
    /** @var Request $request */
    $request = $container->get('request');
    
    $formSignIn = $formFactory->createBuilder('\Recipy\Form\SignInType',$user)
        ->setAction($request->getUriForPath($container->get('router')->get('login')->getPath()))
        ->getForm();

    $formSignIn->handleRequest($request);

    if ($formSignIn->isValid()) {
        initSession($request, $container->get('session'), $user, ['withPass' => true]);
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
