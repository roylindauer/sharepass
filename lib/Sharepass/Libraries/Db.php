<?php
namespace Royl\Sharepass\Libraries;

class Db {

    public $conn;
    public $conn_params;

    public function __construct() {
        try {
            $config = new \Doctrine\DBAL\Configuration();
            $this->connectionParams = array(
                'url' => getenv('ROYLSP_DATABASE_URL'),
                'driver' => 'pdo_mysql',
            );
            $this->conn = \Doctrine\DBAL\DriverManager::getConnection($this->connectionParams, $config);
        } catch (\Exception $e) {
            die('Error handling would be nice...');
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function executeQuery($sql, $data) {
        try {
            return $this->conn->executeQuery($sql, $data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insert($sql, $data) {
        try {
            return $this->conn->insert($sql, $data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

}