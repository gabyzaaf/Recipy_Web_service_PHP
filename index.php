<?php

require_once 'vendor/autoload.php';

session_start();
$loader = new Twig_Loader_Filesystem('./views/');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());
$twig->addExtension(new Recipy\Extension\Twig\User());

$template = $twig->loadTemplate('home.html.twig');

echo $template->render([]);