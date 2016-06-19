<?php

require_once 'appKernel.php';
/** @var Utilisateur $user */

$user = $session->get('user');

if ($user === null
    || !$user instanceof Utilisateur
    || !$user->loadCurrentUser()
) {
    $session->clear();
}

$template = $twig->loadTemplate('home.html.twig');

echo $template->render([]);