<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('index', new Route(
    '/',
    array(
        '_controller' => 'App\Controllers\LinkdataController::invoke',
        '_action' => 'index'
    ),
    [],
    [],
    null,
    [],
    'GET'
));

$routes->add('generate_link', new Route(
    '/',
    array(
        '_controller' => 'App\Controllers\LinkdataController::invoke',
        '_action' => 'add'
    ),
    [],
    [],
    null,
    [],
    'POST'
));

$routes->add('view_link', new Route(
    '/link/{key}',
    array(
        '_controller' => 'App\Controllers\LinkdataController::invoke',
        '_action' => 'view',
        'key' => null
    ),
    array('key' => '(.*)'),
    [],
    null,
    [],
    'GET'
));

return $routes;
