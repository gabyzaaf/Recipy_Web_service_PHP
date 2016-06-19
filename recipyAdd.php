<?php

include 'appKernel.php';

use Symfony\Component\Form as Form;

/**
 * Controller : RecipyAdd
 */

/** @var Utilisateur $user */
$user = $session->get('user');

if ($user === null
    || !$user instanceof Utilisateur
    || !$user->loadCurrentUser()
) {
    $session->clear();
    header('Location: /index.php');
}
$template = $twig->loadTemplate('page/recipy/add.html.twig');


/**
 * Controller to Add Recipy
 */

$recipy = new Recette();
$form = $formFactory->createBuilder('\Recipy\Form\RecipyType', $recipy)
    ->add('save', Form\Extension\Core\Type\SubmitType::class, array('label' => 'Add'))
    ->getForm();

$form->handleRequest($request);

if ($form->isValid()) {
    if ($recipy->exist()) {
        $session->getFlashBag()
            ->add('error', 'This recipe is exists.');
    } else if ($recipy->add()) {
        $session->getFlashBag()
            ->add('error', 'An error occurred while trying to add.');
    } else {
        $session->getFlashBag()
            ->add('success', 'This recipe has been insert.');
    }
}

$formViewRecipy = $form->createView();

echo $template->render(array('form' => $formViewRecipy));
