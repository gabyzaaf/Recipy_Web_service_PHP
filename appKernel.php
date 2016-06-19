<?php


require_once 'vendor/autoload.php';
require_once 'class/Utilisateur.php';
require_once 'class/Recette.php';

use Symfony\Component\Form as Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Twig\Extension;

$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start();
/** INIT HTTP REQUEST MANAGER */
$request = new \Symfony\Component\HttpFoundation\Request($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);
/** INIT TEMPLATING */
$loader = new Twig_Loader_Filesystem(['./views/', './vendor/symfony/twig-bridge/Resources/views/Form/']);
$twig = new Twig_Environment($loader, array('debug' => true));
$engine = new \Symfony\Bridge\Twig\Form\TwigRendererEngine(array('bootstrap_3_layout.html.twig'));
$engine->setEnvironment($twig);
$twig->addExtension(new Twig_Extension_Debug());
$twig->addExtension(new \Recipy\Extension\Twig\User($session));
$twig->addExtension(new \Recipy\Extension\Twig\Page($request));
$twig->addExtension(new Twig_Extensions_Extension_Text());
$twig->addExtension(new Extension\TranslationExtension(new \Symfony\Component\Translation\Translator('fr')));
$twig->addExtension(new Extension\FormExtension(new \Symfony\Bridge\Twig\Form\TwigRenderer($engine)));
$twig->addGlobal('app', [
    'session' => $session,
    'request' => $request
]);

/** Enable validation by static method in Entity */
/** @var \Symfony\Component\Validator\ValidatorBuilder $validator */
$validator = \Symfony\Component\Validator\Validation::createValidatorBuilder();
$validator->addMethodMapping('loadValidatorMetadata');
$formFactory = Form\Forms::createFormFactoryBuilder()
    ->addExtension(new Form\Extension\HttpFoundation\HttpFoundationExtension())
    ->addExtension(new Form\Extension\Validator\ValidatorExtension($validator->getValidator()))
    ->getFormFactory();


include_once 'signin.php';
include_once 'signup.php';


/**
 * @param Request     $request
 * @param Session     $session
 * @param Utilisateur $user
 */
function initSession(Request $request, Session $session, Utilisateur $user)
{

    if (!$user->exist()) {
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
