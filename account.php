<?php

include 'appKernel.php';

/**
 * Controller : Account
 */

use Symfony\Component\Form as Form;

$template = $twig->loadTemplate('page/account.html.twig');

$user = new utilisateur();

$formFactory = Form\Forms::createFormFactoryBuilder()
    ->addExtension(new Form\Extension\HttpFoundation\HttpFoundationExtension())
    ->getFormFactory();

$form = $formFactory->createBuilder('\Recipy\Form\UserType')
    ->add('save', Form\Extension\Core\Type\SubmitType::class, array('label' => 'Send'))
    ->getForm();

$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    /** TODO: process de mise a jour */
    dump('VALID', $form->getData());
    die;
}

$view = $form->createView();

echo $template->render(array('form' => $view));
