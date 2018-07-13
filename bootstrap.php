<?php

date_default_timezone_set('America/Los_Angeles');

$BASEDIR = realpath(dirname(__FILE__));

require_once $BASEDIR . '/vendor/autoload.php';

$Loader = (new josegonzalez\Dotenv\Loader($BASEDIR . '/.env'))
               ->parse()
               ->prefix('ROYLSP_')
               ->putenv(true);


