<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('./views/');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension( new Twig_Extension_Debug());
$twig->addExtension( new \Recipy\Extension\Twig\User());
$template = $twig->loadTemplate('account.html.twig');
session_start();
$app = ['user' => [
    'isLogged' => !!$_SESSION['id']
]
];

echo $template->render(array('app' => $app));
