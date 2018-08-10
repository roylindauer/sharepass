<?php
namespace Royl\Sharepass\Models;

class Linkdata {

    /**
     * @var
     */
    private $encryptionKey;

    /**
     * @var array
     */
    public $linkdata = array(
        'data_encrypted' => false,
        'data_raw' => false,
    );

    /**
     * @var \Royl\Sharepass\Libraries\Db
     */
    public $DBConnection;

    /**
     * @var \Royl\Sharepass\Data\Linkdata
     */
    public $Data;

    public function __construct(\Royl\Sharepass\Libraries\Db $DBConnection, \Royl\Sharepass\Data\Linkdata $Data) {
        $this->DBConnection = $DBConnection;
        $this->Data = $Data;
    }

    public function createDefaultEncryptionKey() {
        $this->encryptionKey = uniqid();
    }

    public function setLinkdata($linkdata) {
        if (isset($linkdata['data'])) {
            $this->setEncryptedLinkdata($linkdata['data']);
        }
        if (isset($linkdata['expires'])) {
            $this->setExpires($linkdata['expires']);
        }
    }

    public function getRawLinkData() {
        return $this->linkdata['data_raw'];
    }

    public function setRawLinkData($data_raw) {
        $this->linkdata['data_raw'] = $data_raw;
    }

    public function getEncryptedLinkData() {
        return $this->linkdata['data_encrypted'];
    }

    public function setEncryptedLinkdata($data_encrypted){
        $this->linkdata['data_encrypted'] = $data_encrypted;
    }

    public function getEncryptionKey() {
        return $this->encryptionKey;
    }

    public function setEncryptionKey($key) {
        $this->encryptionKey = $key;
    }

    public function filterSpecialCharsFromLinkdata() {
        return filter_var($this->getRawLinkData(), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getExpires() {
        return $this->linkdata['expires'];
    }

    public function setExpires($expires) {
        $this->linkdata['expires'] = $expires;
    }

    public function getNewLinkKey($data) {
        $data = filter_var($data);
        $this->setRawLinkdata($data);
        $this->saveLinkData();
        return $this->getEncryptionKey();
    }

    public function saveLinkData() {
        try {
            $this->createDefaultEncryptionKey();
            $this->encryptLinkdata();
            $this->Data->saveEncryptedLinkData($this->getEncryptionKey(), $this->getEncryptedLinkData());
        } catch (\Exception $e) {

        }
    }
    public function encryptLinkdata() {
        $encrypt = new \JaegerApp\Encrypt();
        $encrypt->setKey($this->getEncryptionKey());
        $this->setEncryptedLinkdata($encrypt->encode($this->getRawLinkData()));
    }

    public function getLinkData($key) {
        $this->setEncryptionKey($key);
        $this->decryptLink();
        return $this->filterSpecialCharsFromLinkdata();
    }

    public function decryptLink() {
        try {
            $this->setLinkdata($this->Data->getLinkDataRecord($this->getEncryptionKey()));
            $this->deleteIfLinkExpired();
            $this->decryptLinkData();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function decryptLinkData() {
        try {
            $encrypt = new \JaegerApp\Encrypt();
            $encrypt->setKey($this->getEncryptionKey());
            $this->setRawLinkData($encrypt->decode($this->getEncryptedLinkData()));
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteIfLinkExpired() {
        try {
            if ($this->linkIsExpired())  {
                $this->Data->deleteLink($this->getEncryptionKey());
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function linkIsExpired() {
        return strtotime(date('Y-m-d H:i:s')) > strtotime($this->getExpires());
    }
}