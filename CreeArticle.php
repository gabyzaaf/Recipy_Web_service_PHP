<?php
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 03/03/2016
 * Time: 20:39
 */
session_start();
?>
<html>

<head>

</head>


<body>
<?php
    require_once('menu/menu.php');
?>



<center>
    <fieldset>
        <legend>Ecrire votre article</legend>
    <form enctype="multipart/form-data" method="post" onsubmit="return mySubmitFunction()" action="TratementArticles.php">
        <table>
            <tr>
                <td>Title de l'article</td>
            </tr>
            <tr>
                <td><input type="text" style="width: 300px;" name="title" ></td>
            </tr>
            <tr>
                <td>Contenu de l'article</td>
            </tr>
            <tr>
                <td><textarea rows="10" cols="50" name="content" ></textarea></td>
            </tr>
            <tr>
                <td>Image</td>
            </tr>
            <tr>
                <td><input type="file" name="file"></td>
            </tr>
            <tr>
                <td><input type="submit" value="creer article"></td>
            </tr>
        </table>

    </form>
    </fieldset>
</center>
<script src="verification.js"></script>
</body>


</html>

