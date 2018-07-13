<?php
namespace Royl\Sharepass;

class Db {

    public $conn;

    public function __construct() {

        $config = new \Doctrine\DBAL\Configuration();
        $connectionParams = array(
            'url' => getenv('ROYLSP_DATABASE_URL'),
            'driver' => 'pdo_mysql',
        );
        $this->conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    }
}