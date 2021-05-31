<?php

date_default_timezone_set('America/Los_Angeles');

$BASEDIR = realpath(dirname(__DIR__));
define('BASEDIR', $BASEDIR);

require_once BASEDIR . '/vendor/autoload.php';

$Services = new App\Services\Services();

function get_service($service) {
    global $Services;
    return $Services->get($service);
}

if (file_exists(BASEDIR . '/.env')) {
    $EnvLoader = (new josegonzalez\Dotenv\Loader(BASEDIR . '/.env'))
        ->parse()
        ->putenv(true);
}

$Kernel = new App\Kernel();
$Kernel->init();
