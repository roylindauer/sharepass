<?php
namespace Royl\Sharepass\Libraries;

use Royl\Sharepass\Data;

class Linkdata {

    private $encryptionKey;
    private $linkdata = array(
        'data_encrypted' => false,
        'data_raw' => false,
    );

    public function setupLinkdata($key, $data) {
        $this->setEncryptionKey($key);

        if (isset($data['data'])) {
            $this->setEncryptedLinkdata($data['data']);
        }

        if (isset($data['expires'])) {
            $this->setExpires($data['expires']);
        }
    }

    public function createDefaultEncryptionKey() {
        $this->encryptionKey = uniqid();
    }

    public function getEncryptionKey() {
        return $this->encryptionKey;
    }

    public function setEncryptionKey($key) {
        $this->encryptionKey = $key;
    }

    public function getExpires() {
        return $this->linkdata['expires'];
    }

    public function setExpires($expires) {
        $this->linkdata['expires'] = $expires;
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

    public function filterSpecialCharsFromLinkdata() {
        return filter_var($this->getRawLinkData(), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function linkIsExpired() {
        return strtotime(date('Y-m-d H:i:s')) > strtotime($this->getExpires());
    }
}