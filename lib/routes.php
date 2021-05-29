<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('index', new Route(
    '/',
    array(
        '_controller' => 'Royl\Sharepass\Controllers\LinkdataController::invoke',
        '_action' => 'index'
    )
));

$routes->add('generate_link', new Route(
    '/add',
    array(
        '_controller' => 'Royl\Sharepass\Controllers\LinkdataController::invoke',
        '_action' => 'add'
    )
));

$routes->add('view_link', new Route(
    '/link/{key}',
    array(
        '_controller' => 'Royl\Sharepass\Controllers\LinkdataController::invoke',
        '_action' => 'view'
    ),
    array('key' => '(.*)')
));
