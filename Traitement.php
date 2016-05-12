<?php
require_once("class/utilisateur.php");
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 02/03/2016
 * Time: 21:00
 */
session_start();
if((empty($_POST['login'])) || (empty($_POST['pass']))){
    header('Location: index.php?err=1');
    exit();
}else{
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $user = new Utilisateur(NULL,NULL,NULL,$login,NULL,1,NULL,$pass,0);
    $arrayUser = $user->getConnexion();



    $_SESSION['id'] = $arrayUser[0]['id'];
    $_SESSION['login'] = $arrayUser[0]['logins'];
    $_SESSION['nom'] = $arrayUser[0]['nom'];
    $_SESSION['admin'] = $arrayUser[0]['admin'];
    $_SESSION['prenom'] = $arrayUser[0]['prenom'];
    $_SESSION['email'] = $arrayUser[0]['email'];
    $hashValue = sha1($_POST['login']."".$_POST['pass']);

    $val = $user->checkingToken($_SESSION['id']);


    $user->setToken($hashValue);
    // now create the token
    /*
     *  ERR = 8 is when you can't connect the user
     *
     * */
    if(($user->activeSession($_SESSION['id']))==false){
        header('Location: index.php?err=8');
    }
    $_SESSION['Token']=$hashValue;
    if($_SESSION['admin']==True){
        header('Location: index.php?err=8');
    }
}
?>

<html>
    <head>
        <style>
            fieldset
            {
                background-color:#CCC;
                max-width:500px;
                padding:16px;
            }
            .legend1
            {
                margin-bottom:0px;
                margin-left:16px;
                text-align:center;
            }
        </style>
    </head>


    <body>
   <?php
    require_once('menu/menu.php');
   ?>

    <div class="legend1">
    <center>
            <fieldset>
                <legend>Identification : </legend>
               <table>
                   <tr>
                    <td><label>nom :</label></td><td><label><?php echo $_SESSION['nom']?></label></td>
                </tr>
                <tr>
                    <td><label>prenom :</label></td><td><label><?php echo $_SESSION['prenom']?></label></td>
                </tr>
                <tr>
                    <td><label>email :</label></td><td><labe><?php echo $_SESSION['email']?></labe></td>
                </tr>
               </table>
            </fieldset>
    </center>
    </div>
    </body>

</html>