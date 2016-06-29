<?php

require_once 'appKernel.php';

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Router;

// look inside *this* directory
$locator = new FileLocator(array(__DIR__));
$loader = new YamlFileLoader($locator);
$collection = $loader->load('routes.yml');

$requestContext = new RequestContext('/config');

$router = new Router(
    new YamlFileLoader($locator),
    'routes.yml',
    array('cache_dir' => __DIR__.'/cache'),
    $requestContext
);
$router->match('/foo/bar');
