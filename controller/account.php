<?php

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form as Form;
use Recipy\Entity\Utilisateur;
use Recipy\Entity\Recette;

/**
 * Controller : Account
 */

/** @var Utilisateur $user */
$user = $session->get('user');

/** @var AuthorizationChecker $authorizationChecker */
$authorizationChecker = $container->get('authorizationChecker');

if (!$authorizationChecker->isGranted('ROLE_USER')) {
    $session->clear();
    header('Location: '.$container->get('router')->get('index')->getPath());
}

$template = $twig->loadTemplate('page/account.html.twig');

/** @var Request $request */
$request = $container->get('request');
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
 * Controller to My recipes part
 */

$formSearch = $formFactory->createBuilder()
    ->add('acq', Form\Extension\Core\Type\TextType::class,['required' => true])
    ->setAction($container->get('request')->attributes->get('request_uri'))
    ->setMethod('get')
    ->getForm();

if(!empty($request->get('acq')))
    $formSearch->submit(['acq' => $request->get('acq')]);

$recipe = new Recette();
$page = $request->attributes->get('page');

if ($formSearch->isValid()) {
    $formDatas = $formSearch->getData();
    $recipies = $recipe->findByUserIdAndTitle($user->getId(), $formDatas['acq'])->limit(2, $page * 2 -2 )->execute()->fetchAll();
} else {
    $recipies = $recipe->findByUserId($user->getId())->limit(2, $page * 2 -2 )->execute()->fetchAll();
}

$count = $recipe->getPagination();
$countRecipes = count($recipies) > 0 ? count($recipies) : 1;
$pageCount = $count / $countRecipes;

$list = ['recipies' => ['values' => $recipies, 'count' => $count, 'pagination' => ['current' => $page ?? 0, 'count' => $pageCount]]];

echo $template->render(array('form' => $formViewAccount, 'list' => $list));
