<?php
namespace Royl\Sharepass\Helpers;

/**
 * @param $service
 * @return object
 */
function getService($service) {
    global $Services;
    return $Services->get($service);
}