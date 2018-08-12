<?php
namespace Royl\Sharepass\Libraries;

class EncryptLinkdata extends Linkdata {

    public function encryptLinkdata($data) {
        $this->setRawLinkdata($data);
        $this->createDefaultEncryptionKey();

        $encrypt = get_service('app.encrypt');
        $encrypt->setKey($this->getEncryptionKey());

        $this->setEncryptedLinkdata($encrypt->encode($this->getRawLinkData()));
    }
}