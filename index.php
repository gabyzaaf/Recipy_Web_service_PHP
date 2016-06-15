<?php

require_once 'appKernel.php';

$template = $twig->loadTemplate('home.html.twig');

echo $template->render([]);