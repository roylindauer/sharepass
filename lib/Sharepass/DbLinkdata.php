<?php
namespace Royl\Sharepass;

class DbLinkdata {

    public $DB;

    public function __construct(\Royl\Sharepass\Db $DB) {
        $this->DB = $DB;
    }

    public function getLinkDataRecord($key) {
        try {
            $sql = 'SELECT `data`, `expires` FROM `linkdata` WHERE `key` = ?';
            $stmt = $this->DB->executeQuery($sql, array($key));
            return $stmt->fetch();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function saveEncryptedLinkData($key, $data) {
        try {
            $this->DB->insert('linkdata', array(
                '`key`' => $key,
                '`data`' => $data,
                '`created`' => date('Y-m-d H:i:s'),
                '`expires`' => date('Y-m-d H:i:s', strtotime('+1 day')),
            ));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteLink($key) {
        try {
            $sql = 'DELETE FROM `linkdata` WHERE `key` = ?';
            $stmt = $this->DB->executeQuery($sql, array($key));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}