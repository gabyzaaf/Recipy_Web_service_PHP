<?php

ini_set('display_errors', 1);
require_once 'app/appKernel.php';
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

$controller = $container->get('request')->attributes->get('_controller');

if ($controller == 'index' || $controller === null) {

    /** @var AuthorizationChecker $authorizationChecker */
    $authorizationChecker = $container->get('authorizationChecker');

    if (!$authorizationChecker->isGranted('ROLE_USER')) {
        $session->clear();
    }

    $template = $twig->loadTemplate('home.html.twig');

    exit($template->render([]));
}

if (file_exists(CONTROLLER_PATH . $controller . '.php'))
    include_once CONTROLLER_PATH . $controller . '.php';
