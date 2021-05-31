<?php
namespace App\Entities;

class LinkdataEntity {

    private $encryption_key;
    private $data_encrypted;
    private $data_decrypted;
    private $data_raw;
    private $expires;

    public function populate($data) {
        if (isset($data['data_raw'])) {
            $this->setRawLinkData($data['data_raw']);
        }

        if (isset($data['data_encrypted'])) {
            $this->setEncryptedLinkdata($data['data_encrypted']);
        }

        if (isset($data['data_decrypted'])) {
            $this->setDecryptedLinkdata($data['data_decrypted']);
        }

        if (isset($data['expires'])) {
            $this->setExpires($data['expires']);
        }
    }

    public function getLinkdata() {
        return array(
            'data_encrypted' => $this->getEncryptedLinkData(),
            'data_decrypted' => $this->getDecryptedLinkData(),
            'data_raw' => $this->getRawLinkData(),
            'expires' => $this->getExpires(),
            'encryption_key' => $this->getEncryptionKey(),
        );
    }

    public function createDefaultEncryptionKey() {
        $this->encryption_key = uniqid();
    }

    public function getEncryptionKey() {
        return $this->encryption_key;
    }

    public function setEncryptionKey($key) {
        $this->encryption_key = $key;
    }

    public function getExpires() {
        return $this->expires;
    }

    public function setExpires($expires) {
        $this->expires = $expires;
    }

    public function getRawLinkData() {
        return $this->data_raw;
    }

    public function setRawLinkData($data_raw) {
        $this->data_raw = $data_raw;
    }

    public function getEncryptedLinkData() {
        return $this->data_encrypted;
    }

    public function setEncryptedLinkdata($data_encrypted){
        $this->data_encrypted = $data_encrypted;
    }

    public function getDecryptedLinkData() {
        return $this->data_decrypted;
    }

    public function setDecryptedLinkdata($data_decrypted) {
        $this->data_decrypted = $data_decrypted;
    }

    public function sanitizeRawLinkdata() {
        return filter_var($this->getRawLinkData(), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function linkIsExpired() {
        return strtotime(date('Y-m-d H:i:s')) > strtotime($this->getExpires());
    }

    public function decrypt($key) {
        $this->setEncryptionKey($key);

        $encrypt = get_service('app.encrypt');
        $encrypt->setKey($this->getEncryptionKey());

        $this->setDecryptedLinkdata($encrypt->decode($this->getEncryptedLinkData()));
    }

    public function encrypt($data_to_encrypt) {
        $this->createDefaultEncryptionKey();
        $this->setRawLinkData($data_to_encrypt);

        $encrypt = get_service('app.encrypt');
        $encrypt->setKey($this->getEncryptionKey());

        $this->setEncryptedLinkdata($encrypt->encode($this->getRawLinkData()));
    }
}