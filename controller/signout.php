<?php

$session->clear();
header('Location: ' . $container->get('router')->generate('index'));
