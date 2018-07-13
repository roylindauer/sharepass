<?php
namespace Royl\Sharepass;

class DecryptLink extends Linkdata {

    public function getLinkData($key) {
        $this->setEncryptionKey($key);
        $this->decryptLink();
        return $this->sanitizeLinkData();
    }

    public function decryptLink() {
        try {
            $this->setLinkdata($this->DB->getLinkDataRecord($this->getEncryptionKey()));
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
                $this->DB->deleteLink($this->getEncryptionKey());
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function linkIsExpired() {
        if (strtotime(date('Y-m-d H:i:s')) > strtotime($this->getExpires()))  {
            return true;
        }
        return false;
    }
}