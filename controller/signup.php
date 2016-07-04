<?php

use Symfony\Component\Form as Form;
use Recipy\Entity\Utilisateur;

if (!isset($_SESSION['user'])) {

    $action = '/index.php' . $container->get('router')->generate('register');
    $user = new Utilisateur();
    $formSignUp = $formFactory->createBuilder('\Recipy\Form\SignUpType', $user)
        ->setAction($action)
        ->getForm();

    $formSignUp->handleRequest($request);

    if ($formSignUp->isSubmitted() && $formSignUp->isValid()) {
        if ($user->exist()) {
            exit(json_encode(['error' => ['id' => $request, 'message' => 'Username already use.']]));
        }

        $user->createUser();
        initSession($container, $request, $session, $user);
        if ($request->isXmlHttpRequest()) {
            exit(json_encode(['location' => '/account.php']));
        }
        header('Location: ' . $container->get('router')->generate('account'));
    }

    $formViewSignIn = $formSignUp->createView();

    $twig->addGlobal('form_sign_up', $formViewSignIn);

    if ($formSignUp->isSubmitted() && $request->isXmlHttpRequest()) {
        exit(json_encode(['body' => $twig->render('form/modal_signup.html.twig'), 'fail' => $formSignUp]));
    }

    if ($request->getRequestUri() == '/' . basename(__FILE__)) {
        if ($formSignUp->isSubmitted()) {
            exit(json_encode(['body' => $twig->render('form/modal_signup.html.twig'), 'fail' => $formSignUp]));
        } else {
            header('Location: ' . $container->get('router')->generate('index'));
        }
    }
}

