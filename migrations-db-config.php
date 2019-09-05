<?php

date_default_timezone_set('America/Los_Angeles');

if (getenv('IS_PRODUCTION') == false ) {
    $EnvLoader = (new josegonzalez\Dotenv\Loader('.env'))
                   ->parse()
                   ->prefix('ROYLSP_')
                   ->putenv(true);
}

return array(
    'url' => getenv('DATABASE_URL'),
    'driver' => 'pdo_mysql',
);