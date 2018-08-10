<?php

use Royl\Sharepass;

date_default_timezone_set('America/Los_Angeles');

$BASEDIR = realpath(dirname(__DIR__));
define('BASEDIR', $BASEDIR);

require_once BASEDIR . '/vendor/autoload.php';
require_once BASEDIR . '/lib/routes.php';

$Services = new Sharepass\Libraries\Services();

$EnvLoader = (new josegonzalez\Dotenv\Loader(BASEDIR . '/.env'))
               ->parse()
               ->prefix('ROYLSP_')
               ->putenv(true);

$Kernel = new Sharepass\Kernel($routes);
$Kernel->init();

/**
 * @param $service
 * @return object
 */
function get_service($service) {
    global $Services;
    return $Services->get($service);
}