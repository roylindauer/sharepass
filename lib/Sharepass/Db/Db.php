<?php
namespace Royl\Sharepass\Db;

class Db {

    public $conn;
    public $conn_params;

    public function __construct() {

        $config = new \Doctrine\DBAL\Configuration();
        $this->connectionParams = array(
            'url' => getenv('ROYLSP_DATABASE_URL'),
            'driver' => 'pdo_mysql',
        );
        $this->conn = \Doctrine\DBAL\DriverManager::getConnection($this->connectionParams, $config);
    }

    public function getConnection() {
        return $this->conn;
    }

    public function executeQuery($sql, $data) {
        try {
            $stmt = $this->conn->executeQuery($sql, $data);
            return $stmt;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insert($sql, $data) {
        try {
            $stmt = $this->conn->insert($sql, $data);
            return $stmt;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}