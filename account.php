<?php

include_once 'appKernel.php';

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form as Form;

/**
 * Controller : Account
 */

/** @var Utilisateur $user */
$user = $session->get('user');

/** @var AuthorizationChecker $authorizationChecker */
$authorizationChecker = $container->get('authorizationChecker');

if (!$authorizationChecker->isGranted('ROLE_USER')) {
    $session->clear();
    header('Location: '.$container->get('router')->get('index'));
}

$template = $twig->loadTemplate('page/account.html.twig');

/**
 * Controller to My account part
 */

$form = $formFactory->createBuilder('\Recipy\Form\UserType', $user)
    ->add('save', Form\Extension\Core\Type\SubmitType::class, array('label' => 'Send'))
    ->setAction($container->get('request_uri'))
    ->getForm();

$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $user->saveProfile();
    header('Location: '.$container->get('request_uri'));exit();
}

$formViewAccount = $form->createView();

/**
 * Controller to My account part
 */

$recipy = new Recette();
$recipies = $recipy->findByUserId($user->getId());

echo $template->render(array('form' => $formViewAccount, 'list' => ['recipies' => $recipies]));
