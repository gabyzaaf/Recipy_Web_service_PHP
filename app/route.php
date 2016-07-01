<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

// look inside *this* directory
$locator = new FileLocator(array(CONF_PATH ));
$loader = new YamlFileLoader($locator);
$collection = $loader->load('routes.yml');

$requestContext = new RequestContext('/index.php');
$matcher = new \Symfony\Component\Routing\Matcher\UrlMatcher($collection, $requestContext);

$container->set('router', $collection);
$container->set('context', $requestContext);
