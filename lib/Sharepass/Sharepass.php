<?php
namespace Royl\Sharepass;

class Sharepass {

    private $encryptionKey;
    public $linkdata = array(
        'data_encoded' => false,
        'data_raw' => false,
    );

    public function __construct(\Royl\Sharepass\Db $db) {
        $this->db = $db;
        $this->createDefaultEncryptionKey();
    }

    public function decryptLink() {
        $this->setEncryptionKey(filter_var($_GET['key']));
        $this->loadEncryptedLinkData();
        $this->deleteIfLinkExpired();
        $this->decryptLinkData();
        return $this->sanitizeLinkData();
    }

    private function createDefaultEncryptionKey() {
        $this->encryptionKey = uniqid();
    }

    public function getRawLinkData() {
        return $this->linkdata['data_raw'];
    }

    public function setRawLinkData($data_raw) {
         $this->linkdata['data_raw'] = $data_raw;
    }

    public function getLinkData() {
        return $this->linkdata['data_encoded'];
    }

    public function setLinkdata($data){
        $this->linkdata['data_encoded'] = $data;
    }

    public function getEncryptionKey() {
        return $this->encryptionKey;
    }

    public function setEncryptionKey($key) {
        $this->encryptionKey = $key;
    }

    public function loadEncryptedLinkData() {
        try {
            $sql = 'SELECT `data`, `expires` FROM `linkdata` WHERE `key` = ?';
            $stmt = $this->db->conn->executeQuery($sql, array($this->getEncryptionKey()));
            $linkdata = $stmt->fetch();

            if (count($linkdata) < 1) {
                die('This link no longer exists.');
            }

            $this->linkdata = $linkdata;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteIfLinkExpired() {
        try {
            if ($this->linkIsExpired())  {
                $sql = 'DELETE FROM `linkdata` WHERE `key` = ?';
                $stmt = $this->db->conn->executeQuery($sql, array($this->getEncryptionKey()));
                die('This link has expired.');
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function linkIsExpired() {
        if (strtotime(date('Y-m-d H:i:s')) > strtotime($this->linkdata['expires']))  {
            return true;
        }
        return false;
    }

    public function decryptLinkData() {
        $encrypt = new \JaegerApp\Encrypt();
        $encrypt->setKey($this->getEncryptionKey());
        $this->setRawLinkData($encrypt->decode($this->linkdata['data_encoded']));
    }

    public function sanitizeLinkData() {
        return filter_var($this->getRawLinkData(), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function generateLink() {
        $this->setRawLinkdata(filter_var($_POST['mydata']));
        $this->encryptLinkdata();
        $this->saveEncryptedLinkData();
        return sprintf('%s?key=%s', getenv('ROYLSP_DOMAIN'), $this->getEncryptionKey());
    }

    public function saveEncryptedLinkData() {
        try {
            $this->db->conn->insert('linkdata', array(
                '`key`' => $this->getEncryptionKey(),
                '`data`' => $this->getLinkData(),
                '`created`' => date('Y-m-d H:i:s'),
                '`expires`' => date('Y-m-d H:i:s', strtotime('+1 day')),
            ));
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function encryptLinkdata() {
        $encrypt = new \JaegerApp\Encrypt();
        $encrypt->setKey($this->getEncryptionKey());
        $this->setLinkdata($encrypt->encode($this->getRawLinkData()));
    }
}