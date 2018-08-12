<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

// Index
$subCollection = new RouteCollection();
$subCollection->add('index', new Route(
    '/', 
    array(
        '_controller' => '\Royl\Sharepass\Controllers\LinkdataController::invoke',
        '_action' => 'index'
    )
));
$subCollection->setMethods(array('GET'));
$routes->addCollection($subCollection);

// Add New Link
$subCollection = new RouteCollection();
$subCollection->add('generate_link', new Route(
    '/',
    array(
        '_controller' => '\Royl\Sharepass\Controllers\LinkdataController::invoke',
        '_action' => 'add'
    )
));
$subCollection->setMethods(array('POST'));
$routes->addCollection($subCollection);

// View Link
$subCollection = new RouteCollection();
$subCollection->add('view_link', new Route(
    '/link/{key}',
    array(
        '_controller' => '\Royl\Sharepass\Controllers\LinkdataController::invoke',
        '_action' => 'view'
    ),
    array('key' => '(.*)')
));
$subCollection->setMethods(array('GET'));
$routes->addCollection($subCollection);

