<?php
namespace Royl\Sharepass;

class EncryptLink extends Linkdata {

    public function getNewLink() {
        $this->saveLinkData();
        return sprintf('%s?key=%s', getenv('ROYLSP_DOMAIN'), $this->getEncryptionKey());
    }

    public function saveLinkData() {
        $this->createDefaultEncryptionKey();
        $this->setRawLinkdata(filter_var($_POST['mydata']));
        $this->encryptLinkdata();
        $this->DB->saveEncryptedLinkData($this->getEncryptionKey(), $this->getEncryptedLinkData());
    }

    public function encryptLinkdata() {
        $encrypt = new \JaegerApp\Encrypt();
        $encrypt->setKey($this->getEncryptionKey());
        $this->setEncryptedLinkdata($encrypt->encode($this->getRawLinkData()));
    }
}