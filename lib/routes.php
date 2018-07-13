<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('generate_link', new Route(
    '/', 
    array('_controller' => '\Royl\Sharepass\Controllers\LinkdataController::index')
));

$routes->add('view_link', new Route(
    '/link/{key}',
    array('_controller' => '\Royl\Sharepass\Controllers\LinkdataController::view'),
    array('key' => '(.*)')
));

$routes->add('hello', new Route('/hello/{name}', array(
    '_controller' => function (Request $request) {
        return new Response(
            sprintf("Hello %s", $request->get('name'))
        );
    })
));