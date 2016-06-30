<?php

require_once 'appKernel.php';
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

$controller = $container->get('request')->attributes->get('_controller');
if($controller == 'index' || $controller === null) {

    /** @var AuthorizationChecker $authorizationChecker */
    $authorizationChecker = $container->get('authorizationChecker');

    if (!$authorizationChecker->isGranted('ROLE_USER')) {
        $session->clear();
    }

    $template = $twig->loadTemplate('home.html.twig');

    exit($template->render([]));
}

if(file_exists($controller. '.php'))
    include_once $controller. '.php';
