<?php
require_once __DIR__ . '/Facebook/autoload.php';
session_start();
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 29/02/2016
 * Time: 22:42
 */

$fb = new Facebook\Facebook([
    'app_id' => '976119429102539',
    'app_secret' => '71be34111417200dfed4df1a58db023c',
    'default_graph_version' => 'v2.5',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://localhost:8888/projet_annuel/database/test.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';


?>