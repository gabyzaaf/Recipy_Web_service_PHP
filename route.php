<?php

require_once 'appKernel.php';

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Router;

// look inside *this* directory
$locator = new FileLocator(array(__DIR__ . '/config'));
$loader = new YamlFileLoader($locator);
$collection = $loader->load('routes.yml');

$requestContext = new RequestContext('/');

$container->set('collectionRoutes', $collection);
$container->set('requestContext', $requestContext);

//$router->match('/foo/bar');
