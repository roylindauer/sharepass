<?php

use Royl\Sharepass;

date_default_timezone_set('America/Los_Angeles');

$BASEDIR = realpath(dirname(__DIR__));
define('BASEDIR', $BASEDIR);

require_once BASEDIR . '/vendor/autoload.php';
require_once BASEDIR . '/lib/routes.php';
require_once BASEDIR . '/lib/Sharepass/helpers.php';

$Services = new Sharepass\Services\Services();

if (file_exists(BASEDIR . '/.env')) {
    $EnvLoader = (new josegonzalez\Dotenv\Loader(BASEDIR . '/.env'))
        ->parse()
        ->putenv(true);
}

$Kernel = new Sharepass\SharepassHttpKernel($routes);
$Kernel->init();
