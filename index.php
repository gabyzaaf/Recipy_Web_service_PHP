<?php

require_once 'appKernel.php';

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/** @var AuthorizationChecker $authorizationChecker */
$authorizationChecker = $container->get('authorizationChecker');
if (!$authorizationChecker->isGranted('ROLE_USER')) {
    $session->clear();
}

$template = $twig->loadTemplate('home.html.twig');

echo $template->render([]);
