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
$recipy->load($request->get('id'));

echo $template->render([]);
