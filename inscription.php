<?php
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 05/03/2016
 * Time: 23:42
 */
?>
<html>

<head>


</head>
<body>
    <form method="post" onsubmit="return InscriptionValidation()" action="traitementInscription.php">
        <table>
            <tr><td><label>nom :</label></td><td><input type="text" name="name"></td></tr>
            <tr>
                <td><label>prenom : </label></td><td><input type="text" name="lastname"</td>
            </tr>
            <tr>
                <td><label>login : </label></td><td><input type="text" name="login"></td>
            </tr>
            <tr>
               <td><label>email : </label></td><td><input type="email" name="email"></td>
            </tr>
            <tr>
                <td><label>veuillez resaisir votre email : </label></td><td><input type="email" name="email2"></td>
            </tr>
            <tr>
                <td><label>naissance : </label></td><td><input type="date" name="born"></td>
            </tr>
            <tr>
                <td><label>mot de passe : </label></td><td><input type="password" name="mdp"></td>
            </tr>
            <tr>
                <td><input type="submit"></td>
            </tr>
        </table>

    </form>
<script src="verification.js"></script>
</body>

</html>
