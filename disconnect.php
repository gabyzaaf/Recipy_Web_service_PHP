<?php
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 08/03/2016
 * Time: 16:25
 */
require_once('class/utilisateur.php');
session_start();
$utilisateur = new Utilisateur();
$utilisateur->DesactiveSession($_SESSION["id"]);


session_destroy();
/*
 * Annotation : disco = 1 (is the user is disconnect)
 *
 *
 * */

header('Location: index.php?disco=1');

?>