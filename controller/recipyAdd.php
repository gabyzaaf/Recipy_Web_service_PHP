<?php

use Symfony\Component\Form as Form;
use Recipy\Entity\Utilisateur;
use Recipy\Entity\Recette;

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
$form = $formFactory->createBuilder(\Recipy\Form\RecipyType::class, $recipy)
    ->add('save', Form\Extension\Core\Type\SubmitType::class,
        ['label' => 'Add', 'attr' => ['class' => 'btn btn-default pull-right']])
    ->add('return_list', Form\Extension\Core\Type\SubmitType::class,
        ['label' => 'Return to list',
         'validation_groups' => false,
         'attr' =>
            [
                'formnovalidate' => 'formnovalidate',
                'class' => 'btn btn-default pull-right',
                'style' => 'margin-right: 10px;'
            ]
        ])
    ->getForm();

$form->handleRequest($request);

if ($form->get('return_list')->isClicked()) {
    header('Location: account.php?section=recipy');
}

if ($form->isValid()) {
    if ($recipy->exist()) {
        $session->getFlashBag()
            ->add('error', 'This recipe is exists.');
    } else if (!$recipy->add()) {
        $session->getFlashBag()
            ->add('error', 'An error occurred while trying to add.');
    } else {
        $session->getFlashBag()
            ->add('success', 'This recipe has been insert.');
    }
}

$formViewRecipy = $form->createView();

echo $template->render(array('form' => $formViewRecipy));
