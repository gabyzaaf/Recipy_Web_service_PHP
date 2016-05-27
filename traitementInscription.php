<?php

include_once "appKernel.php";

use Symfony\Component\Form as Form;

$template = $twig->loadTemplate('page/account.html.twig');

$formFactory = Form\Forms::createFormFactoryBuilder()
    ->addExtension(new Form\Extension\HttpFoundation\HttpFoundationExtension())
    ->getFormFactory();

$user = new utilisateur();

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

///*
// *  Err = 1 is if a credential is false
// *
// * */
//if(empty($_POST['name']) ||empty($_POST['lastname']) || empty($_POST['login']) || empty($_POST['email']) || empty($_POST['email2']) || empty($_POST['born']) || empty($_POST['mdp']) || empty($_POST['mdp2'])){
//    header('Location: inscription.php?err=1');
//}
///*
// *  Err = 2 the email 1 and email 2 is not identic
// *  Err = 3 the pass 1 and the pass 2 is not identic
// * */
//
//if($_POST['email']!=$_POST['email2']){
//    header('Location: inscription.php?err=2');
//}else if($_POST['mdp']!=$_POST['mdp2']){
//    header('Location: inscription.php?err=3');
//}else{
//
//    $userObject = new Utilisateur(NULL,$_POST['name'],$_POST['lastname'],$_POST['login'],$_POST['email'],NULL,$_POST['born'],$_POST['mdp'],NULL);
//
//    $arruser = $userObject->exist();
//
//    if($arruser[0]['nb']=="0"){
//
//        if($userObject->createUser()){
//            /*
//             *  OK = the user is created
//             * */
//            header('Location: index.php?ok=1');
//        }else{
//            /*
//             * Err = 5 the user don't was create
//             *
//             * */
//            header('Location: inscription.php?err=5');
//        }
//    }else{
//        /*
//         * The User are already created
//         *
//         * */
//        header('Location: inscription.php?err=4');
//    }
//}
