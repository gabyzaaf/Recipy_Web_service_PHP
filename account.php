<?php

include 'appKernel.php';

use Symfony\Component\Form as Form;

/**
 * Controller : Account
 */

if($session->get('user') === null)
    header('Location: /index.php');


$template = $twig->loadTemplate('page/account.html.twig');

/** @var Utilisateur $user */
$user = $session->get('user');

$user->loadCurrentUser();
/**
 * Controller to My account part
 */
$form = $formFactory->createBuilder('\Recipy\Form\UserType', $user)
    ->add('save', Form\Extension\Core\Type\SubmitType::class, array('label' => 'Send'))
    ->getForm();

$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $user->saveProfile();
    header('Location: /account.php');exit();
}

$formViewAccount = $form->createView();

/**
 * Controller to My account part
 */

$recipy = new Recette();
$recipies = $recipy->findByUserId($user->getId());

echo $template->render(array('form' => $formViewAccount, 'list' => ['recipies' => $recipies]));
