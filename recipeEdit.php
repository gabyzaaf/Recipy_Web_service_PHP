<?php

include 'appKernel.php';

use Symfony\Component\Form as Form;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
    exit(new RedirectResponse('/index.php'));
}
$template = $twig->loadTemplate('page/recipy/edit.html.twig');


/**
 * Controller to Add Recipy
 */
if($request->get('id') === null) {
    exit(new RedirectResponse($request->headers->get('referer')));
}

$recipy = new Recette();
$form = $formFactory->createBuilder('\Recipy\Form\RecipyType', $recipy)

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
    if (!$recipy->exist()) {
        $session->getFlashBag()
            ->add('error', 'This recipe has not found.');
    } else if (!$recipy->save()) {
        $session->getFlashBag()
            ->add('error', 'An error occurred while trying to save.');
    } else {
        $session->getFlashBag()
            ->add('success', 'This recipe has been save.');
    }
}

$formViewRecipy = $form->createView();

echo $template->render(array('form' => $formViewRecipy));
