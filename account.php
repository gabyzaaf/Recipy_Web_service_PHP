<?php

include 'appKernel.php';

/**
 * Controller : Account
 */

use Symfony\Component\Form as Form;

$template = $twig->loadTemplate('page/account.html.twig');

$formFactory = Form\Forms::createFormFactoryBuilder()
    ->addExtension(new Form\Extension\HttpFoundation\HttpFoundationExtension())
    ->getFormFactory();

$user = new utilisateur();
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
$recipies = $recipy->findByUserId($_SESSION['user']['id']);

echo $template->render(array('form' => $formViewAccount, 'list' => ['recipies' => $recipies]));
