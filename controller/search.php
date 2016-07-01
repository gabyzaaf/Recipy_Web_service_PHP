<?php

use Symfony\Component\Form as Form;
use Recipy\Entity\Recette;

/**
 *  Controller : Search
 */
$limit = $container->get('config')['data']['list']['limit'] ?? 0;
$template = $twig->loadTemplate('page/search.html.twig');

$formSearch = $formFactory->createBuilder()
    ->add('q', Form\Extension\Core\Type\TextType::class, ['required' => true])
    ->setAction($container->get('request')->attributes->get('request_uri'))
    ->setMethod('get')
    ->getForm();

if (!empty($request->get('q')))
    $formSearch->submit(['q' => $request->get('q')]);

$recipe = new Recette();
$page = $request->attributes->get('page');

if ($formSearch->isValid()) {
    $formDatas = $formSearch->getData();
    $recipies = $recipe->findByVisibilityAndTitle($formDatas['q'], true)->limit($limit, $page * $limit - $limit)->execute()->fetchAll();
} else {
    $recipies = $recipe->findByVisibility(true)->limit($limit, $page * $limit - $limit)->execute()->fetchAll();
}

$count = $recipe->getPagination();
$countRecipes = $limit > 0 ? $limit : 1;
$pageCount = ceil($count / $countRecipes);

$list = ['recipies' => ['values' => $recipies, 'count' => $count, 'pagination' => ['current' => $page ?? 0, 'count' => $pageCount]]];

$formViewSignIn = $formSearch->createView();

$twig->addGlobal('form_search', $formViewSignIn);
$twig->addGlobal('list', ($twig->getGlobals()['list']??[]) + $list);

exit($template->render([]));