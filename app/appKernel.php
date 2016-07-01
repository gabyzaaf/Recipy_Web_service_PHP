<?php

include_once 'prepend.php';
require_once VENDOR_PATH . '/autoload.php';

use Symfony\Component\Form as Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Twig\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Translation;

use Recipy\Entity\Utilisateur;

$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start();

/** INIT CONTAINER */
$container = new ContainerBuilder();
$ymlLoader = new YamlFileLoader($container, new FileLocator(CONF_PATH));
$container->set('container', $container);


/** ROUTER */
require_once 'route.php';

/** INIT HTTP REQUEST MANAGER */
$request = new \Symfony\Component\HttpFoundation\Request($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);

try {
    $attributes = $matcher->match($request->getPathInfo());
    $request->attributes->replace($attributes);
} catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    //
} catch (\Symfony\Component\Routing\Exception\MethodNotAllowedException $e) {
    //
}

/** SET CONTAINER DATA */
$container->set('session', $session);
$container->set('user', $session->get('user')?? new Utilisateur());
$container->set('request', $request);
$container->set('request_uri', $container->get('request')->getRequestUri());
$ymlLoader->load('form.yml');
$ymlLoader->load('twig_extension.yml');


/** SECURITY */
require_once 'security.php';

/** LOAD TRANSLATION */
$translator = new Translation\Translator('fr_FR');
$translator->addLoader('yaml', new Translation\Loader\YamlFileLoader());
$translator->setFallbackLocales(array('fr_FR'));
$translator->setLocale('fr_FR');
$translator->addResource('yaml', 'config/messages.fr.yml', 'fr_FR');

/** INIT TEMPLATING */
$loader = new Twig_Loader_Filesystem([TPL_PATH, VENDOR_PATH . 'symfony/twig-bridge/Resources/views/Form/']);
$twig = new Twig_Environment($loader, array('debug' => true));
$engine = new \Symfony\Bridge\Twig\Form\TwigRendererEngine(array('bootstrap_3_layout.html.twig'));
$engine->setEnvironment($twig);
$twig->addExtension(new Twig_Extension_Debug());
$twig->addExtension($container->get('twig.extension.user'));
$twig->addExtension($container->get('twig.extension.page'));
$twig->addExtension($container->get('twig.extension.routing'));
$twig->addExtension(new Extension\TranslationExtension($translator));
$twig->addExtension(new Twig_Extensions_Extension_Text());
$twig->addExtension(new Extension\FormExtension(new \Symfony\Bridge\Twig\Form\TwigRenderer($engine)));
$twig->addGlobal('request', $request);
$twig->addGlobal('app', [
    'session'    => $session,
    'request'    => $request,
    'translator' => $translator,
]);

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


include_once CONTROLLER_PATH . 'signin.php';
include_once CONTROLLER_PATH . 'signup.php';


/**
 * @param Request     $request
 * @param Session     $session
 * @param Utilisateur $user
 * @param array       $options
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
