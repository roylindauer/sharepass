<?php
namespace Royl\Sharepass;

class Linkdata extends Sharepass {

    public $linkdata = array(
        'data_encrypted' => false,
        'data_raw' => false,
    );
    private $encryptionKey;

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

    public function sanitizeLinkData() {
        return filter_var($this->getRawLinkData(), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getExpires() {
        return $this->linkdata['expires'];
    }

    public function setExpires($expires) {
        $this->linkdata['expires'] = $expires;
    }
}