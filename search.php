<?php

require_once 'appKernel.php';

use Symfony\Component\Form as Form;

$formSearch = $formFactory->createBuilder()
    ->add('q', Form\Extension\Core\Type\TextType::class,['required' => true])
    ->setAction('index.php')
    ->setMethod('get')
    ->getForm();
if(!empty( $request->get('q')))
$formSearch->submit(['q' => $request->get('q')]);

$recipe = new Recette();
$list = [];
$recipies = [];

if ($formSearch->isValid()) {
    $formDatas = $formSearch->getData();
    $recipies = $recipe->findByTitle($formDatas['q']);
    if ($request->isXmlHttpRequest()) {
        $template = $twig->loadTemplate('list/recipy.html.twig');
        exit(json_encode(['body' => $template->render(['list' => ['recipies' => $recipies]])]));
    }

} else {
    $recipies = $recipe->findAllVisible();
}

$list = ['recipies' => $recipies];

$formViewSignIn = $formSearch->createView();

$twig->addGlobal('form_search', $formViewSignIn);
$twig->addGlobal('list', ($twig->getGlobals()['list']??[]) + $list);
