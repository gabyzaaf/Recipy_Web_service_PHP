<?php

require_once 'vendor/autoload.php';
require_once 'class/Utilisateur.php';
require_once 'class/Recette.php';

session_start();
/** INIT HTTP REQUEST MANAGER */
$request = new \Symfony\Component\HttpFoundation\Request($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);
/** INIT TEMPLATING */
$loader = new Twig_Loader_Filesystem(['./views/', './vendor/symfony/twig-bridge/Resources/views/Form/']);
$twig = new Twig_Environment($loader, array('debug' => true));
$engine = new \Symfony\Bridge\Twig\Form\TwigRendererEngine(array('bootstrap_3_layout.html.twig'));
$engine->setEnvironment($twig);
$twig->addExtension(new Twig_Extension_Debug());
$twig->addExtension(new \Recipy\Extension\Twig\User());
$twig->addExtension(new \Recipy\Extension\Twig\Page($request));
$twig->addExtension(new Twig_Extensions_Extension_Text());
$twig->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension(new \Symfony\Component\Translation\Translator('fr')));
$twig->addExtension(new \Symfony\Bridge\Twig\Extension\FormExtension(new \Symfony\Bridge\Twig\Form\TwigRenderer($engine)));
$twig->addGlobal('request', $request);
