<?php


require_once 'vendor/autoload.php';
require_once 'class/Utilisateur.php';
require_once 'class/Recette.php';

use Symfony\Component\Form as Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Twig\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start();

/** INIT HTTP REQUEST MANAGER */
$request = new \Symfony\Component\HttpFoundation\Request($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);

/** INIT CONTAINER */
$container = new ContainerBuilder();
$containerLoader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
$container->set('container', $container);
$container->set('session', $session);
$containerLoader->load('form.yml');
$containerLoader->load('twig_extension.yml');

/** INIT TEMPLATING */
$loader = new Twig_Loader_Filesystem(['./views/', './vendor/symfony/twig-bridge/Resources/views/Form/']);
$twig = new Twig_Environment($loader, array('debug' => true));
$engine = new \Symfony\Bridge\Twig\Form\TwigRendererEngine(array('bootstrap_3_layout.html.twig'));
$engine->setEnvironment($twig);
$twig->addExtension(new Twig_Extension_Debug());
$twig->addExtension($container->get('twig.extension.user'));
$twig->addExtension(new \Recipy\Extension\Twig\Page($request));
$twig->addExtension(new Twig_Extensions_Extension_Text());
$twig->addExtension(new Extension\TranslationExtension(new \Symfony\Component\Translation\Translator('fr')));
$twig->addExtension(new Extension\FormExtension(new \Symfony\Bridge\Twig\Form\TwigRenderer($engine)));
$twig->addGlobal('request', $request);
$twig->addGlobal('app', ['session' => $session,]);

/** Enable validation by static method in Entity */
/** @var \Symfony\Component\Validator\ValidatorBuilder $validator */
$validator = \Symfony\Component\Validator\Validation::createValidatorBuilder();
$validator->addMethodMapping('loadValidatorMetadata');
$formFactory = Form\Forms::createFormFactoryBuilder()
    ->addExtension(new Form\Extension\HttpFoundation\HttpFoundationExtension())
    ->addExtension(new Form\Extension\Validator\ValidatorExtension($validator->getValidator()))
    ->addType($container->get('form.recipe_edit'))
    ->addType($container->get('form.search'))
    ->getFormFactory();


include_once 'signin.php';
include_once 'signup.php';
include_once 'search.php';


/**
 * @param Request     $request
 * @param Session     $session
 * @param Utilisateur $user
 */
function initSession(Request $request, Session $session, Utilisateur $user, array $options = [])
{
    
    if (!$user->exist($options['withPass']?? false)) {
        if ($request->isXmlHttpRequest()) {
            exit(json_encode(['error' => ['id' => $request, 'message' => 'Incorrect username or password.']]));
        } else {
            header('Location: index.php?err=' . SessionException::$SESSION_LOGIN_FAILED);
            exit();
        }
    }

    $token = md5(sha1($user->getLogins() . $user->getMdp()) . date_timestamp_get(new DateTime('now')));
    $user->setToken($token);
    $user->saveToken();

    $session->set('user', $user->loadUser());
    $request->setSession($session);

    if ($request->isXmlHttpRequest()) {
        exit(json_encode(['location' => 'account.php']));
    }

    header('Location: account.php');
    exit();
}
