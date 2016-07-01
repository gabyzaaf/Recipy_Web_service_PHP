<?php

use Symfony\Component\Form as Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Recipy\Entity\Utilisateur;

use Recipy\Entity\Recette;

/**
 * Controller : RecipyAdd
 */

/** @var AuthorizationChecker $authorizationChecker */
$authorizationChecker = $container->get('authorizationChecker');

if (!$authorizationChecker->isGranted('ROLE_USER')) {
    $session->clear();
    header('Location: ' . $container->get('router')->get('index'));
}

$template = $twig->loadTemplate('page/recipy/edit.html.twig');

/**
 * Controller to Add Recipy
 */
if ($request->get('id') === null) {
    exit(new RedirectResponse($request->headers->get('referer')));
}

$recipy = new Recette();
$recipy->load($request->get('id'));

$form = $formFactory->createBuilder(\Recipy\Form\RecipyType::class, $recipy)
    ->add('save', Form\Extension\Core\Type\SubmitType::class,
        ['label' => 'Save', 'attr' => ['class' => 'btn btn-default pull-right']])
    ->add('return_list', Form\Extension\Core\Type\SubmitType::class,
        ['label'             => 'Return to list',
         'validation_groups' => false,
         'attr'              =>
             [
                 'formnovalidate' => 'formnovalidate',
                 'class'          => 'btn btn-default pull-right',
                 'style'          => 'margin-right: 10px;'
             ]
        ])
    ->getForm();

$form->handleRequest($request);


if($request->headers->get('referer') != $container->get('request')->getSchemeAndHttpHost() .$container->get('request_uri'))
    $container->get('session')->set('referer', $request->headers->get('referer'));

if ($form->get('return_list')->isClicked()) {
    header('Location: ' . $container->get('session')->get('referer'));
    $container->get('session')->set('referer', null);
    exit();
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
