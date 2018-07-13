<?php
/**
 * Generate a one-time link to share sensitive data with 
 * friends and colleauges. 
 * 
 * Input the data you want to share.
 * The data is encrypted and a link is generated.
 * Once the link is used the data is deleted from the system permamently.
 */

date_default_timezone_set('America/Los_Angeles');

require_once 'vendor/autoload.php';

/*
 * Load env variables
 */
$Loader = (new josegonzalez\Dotenv\Loader('.env'))
               ->parse()
               ->prefix('ROYLSP_')
               ->putenv(true);


