<?php

date_default_timezone_set('America/Los_Angeles');

$BASEDIR = realpath(dirname(dirname(__FILE__)));
define('BASEDIR', $BASEDIR);

require_once BASEDIR . '/vendor/autoload.php';
require_once BASEDIR . '/lib/routes.php';

$Loader = (new josegonzalez\Dotenv\Loader(BASEDIR . '/.env'))
               ->parse()
               ->prefix('ROYLSP_')
               ->putenv(true);

$Kernel = new Royl\Sharepass\Kernel($routes);
$Kernel->init();