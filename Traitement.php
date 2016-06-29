<?php
require_once("class/utilisateur.php");
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 02/03/2016
 * Time: 21:00
 */

if((empty($_POST['login'])) || (empty($_POST['pass']))){
    header('Location: index.php?err=1');
}else{
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $user = new Utilisateur(NULL,NULL,NULL,$login,NULL,1,NULL,$pass,0);
    $arrayUser = $user->getConnexion();
    session_start();

    $_SESSION['id'] = $arrayUser[0]['id'];
    $_SESSION['login'] = $arrayUser[0]['logins'];
    $_SESSION['nom'] = $arrayUser[0]['nom'];
    $_SESSION['prenom'] = $arrayUser[0]['prenom'];
    $_SESSION['email'] = $arrayUser[0]['email'];

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
    <center>
    <div class="menu1">
        <fieldset>
            <legend>Menu</legend>
				<table border="1">
					<tr >
						<td><a href="profiUtilisateur.php">informations</a></td>
						<td><a href="ArticlesUtilisateur.php">Consulter ses articles</a></td>
						<td><a href="RechercherArticle.php">Rechercher Article</a></td>
					</tr>
					<tr>
						<td><a href="CreeArticle.php">Creer un nouvel article</a></td>
						<td><a href="ModifierArticle.php">Modifier un article</a></td>
						<td><a href="SupprimerArticle.php">Supprimer un article</a></td>
					</tr>

				</table>
        </fieldset>
    </div>
    </center>

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