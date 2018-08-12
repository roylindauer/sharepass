<?php
namespace Royl\Sharepass\Libraries;

class DecryptLinkdata extends Linkdata {

    public function decryptLink() {
        try {
            $encrypt = get_service('app.encrypt');
            $encrypt->setKey($this->getEncryptionKey());

            $this->setRawLinkData($encrypt->decode($this->getEncryptedLinkData()));
            return $this->filterSpecialCharsFromLinkdata();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}