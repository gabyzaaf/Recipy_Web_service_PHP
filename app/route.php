<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

// look inside *this* directory
$locator = new FileLocator(array(CONF_PATH ));
$loader = new YamlFileLoader($locator);
$collection = $loader->load('routes.yml');
$requestContext = new RequestContext();
$requestContext->fromRequest($container->get('request'));
$router = new \Symfony\Component\Routing\Router($loader, 'routes.yml', [],$requestContext);

$matcher = new \Symfony\Component\Routing\Matcher\UrlMatcher($router->getRouteCollection(), $requestContext);

$container->set('collection_route', $collection);
$container->set('context', $requestContext);
$container->set('router', $router);
