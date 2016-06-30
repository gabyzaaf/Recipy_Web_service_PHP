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
$limitNode = 2;

if ($formSearch->isValid()) {
    $formDatas = $formSearch->getData();
    $recipies = $recipe->findByTitle($formDatas['q']);
    if ($request->isXmlHttpRequest()) {
        $template = $twig->loadTemplate('list/recipy.html.twig');
        exit(json_encode(['body' => $template->render(['list' => ['recipies' => $recipies]])]));
    }

} else {
    $page = $page ?? 0;
    $test = function($closure) use ($recipe, $page){
        return $recipe->$closure(true, 2, $page ?? 0);
    };
    $recipies = $test('findAllVisible');
    dump($recipies);
}

$list = ['recipies' => ['values' => $recipies, 'pagination' => ['current' => $page ?? 0, 'count' => 0]]];

$formViewSignIn = $formSearch->createView();

$twig->addGlobal('form_search', $formViewSignIn);
$twig->addGlobal('list', ($twig->getGlobals()['list']??[]) + $list);
