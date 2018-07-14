<?php
namespace Royl\Sharepass\Libraries;

class EncryptLink extends Linkdata {

    public function getNewLinkKey($data) {
        $this->setRawLinkdata($data);
        $this->saveLinkData();
        return $this->getEncryptionKey();
    }

    public function saveLinkData() {
        $this->createDefaultEncryptionKey();
        $this->encryptLinkdata();
        $this->DB->saveEncryptedLinkData($this->getEncryptionKey(), $this->getEncryptedLinkData());
    }

    public function encryptLinkdata() {
        $encrypt = new \JaegerApp\Encrypt();
        $encrypt->setKey($this->getEncryptionKey());
        $this->setEncryptedLinkdata($encrypt->encode($this->getRawLinkData()));
    }
}