<?php

date_default_timezone_set('America/Los_Angeles');

require 'vendor/autoload.php';

$EnvLoader = (new josegonzalez\Dotenv\Loader('.env'))
               ->parse()
               ->prefix('ROYLSP_')
               ->putenv(true);

return array(
    'url' => getenv('ROYLSP_DATABASE_URL'),
    'driver' => 'pdo_mysql',
);