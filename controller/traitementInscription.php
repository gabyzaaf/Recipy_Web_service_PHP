<?php

use Symfony\Component\Form as Form;
use Recipy\Entity\Utilisateur;

if (true) {
    include_once 'signin.php';
    echo json_encode(['body' => $twig->render('form/modal_signup.html.twig'), 'fail' => $formSignUp]);
    exit();
}

$template = $twig->loadTemplate('page/account.html.twig');

$formFactory = Form\Forms::createFormFactoryBuilder()
    ->addExtension(new Form\Extension\HttpFoundation\HttpFoundationExtension())
    ->addExtension(new Form\Extension\Csrf\CsrfExtension(
        new \Symfony\Component\Security\Csrf\CsrfTokenManager($session, 'recipy')
    ))
    ->getFormFactory();

$user = new Utilisateur();

/**
 * Controller to My account part
 */
$form = $formFactory->createBuilder('\Recipy\Form\SignInType', $user)
    ->add('save', Form\Extension\Core\Type\SubmitType::class, array('label' => 'Send'))
    ->getForm();

$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $user->createUser();

    $arrayUser = $user->getConnexion();

    if (empty($arrayUser)) {
        header('Location: index.php?err=1');
        exit();
    }

    $userData = reset($arrayUser);

    $_SESSION['user']['id'] = $userData['id'];
    $_SESSION['user']['login'] = $userData['logins'];
    $_SESSION['user']['nom'] = $userData['nom'];
    $_SESSION['user']['admin'] = $userData['admin'];
    $_SESSION['user']['prenom'] = $userData['prenom'];
    $_SESSION['user']['email'] = $userData['email'];
    $hashValue = sha1($_POST['login'] . "" . $_POST['pass']);

    $val = $user->checkingToken($_SESSION['user']['id']);


    $user->setToken($hashValue);
    // now create the token
    /*
     *  ERR = 8 is when you can't connect the user
     *
     * */
    if (($user->activeSession($_SESSION['user']['id'])) == false) {
        header('Location: index.php?err=8');
        exit();
    }
    $_SESSION['user']['token'] = $hashValue;
    if ($_SESSION['user']['admin'] == true) {
        header('Location: index.php?err=8');
        exit();
    }
    header('Location: account.php');
    exit();
}

header('Location: ' . $request->headers->get('referer'));
exit();
