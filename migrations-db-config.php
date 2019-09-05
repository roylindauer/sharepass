<?php

date_default_timezone_set('America/Los_Angeles');

if (file_exists(BASEDIR . '/.env')) {
    $EnvLoader = (new josegonzalez\Dotenv\Loader('.env'))
        ->parse()
        ->putenv(true);
}

return array(
    'url' => getenv('DATABASE_URL'),
    'driver' => 'pdo_mysql',
);