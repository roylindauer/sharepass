<?php
namespace Royl\Sharepass\Models;

use Royl\Sharepass\Services;

class Linkdata {
    /**
     * @var \Royl\Sharepass\Database\Linkdata
     */
    public $Data;

    public function __construct(\Royl\Sharepass\Database\Linkdata $Data) {
        $this->Data = $Data;
    }

    public function createLink($data) {
        try {
            $EncryptLinkdata = getService('entity.linkdata');
            $EncryptLinkdata->encryptLinkdata($data);

            $this->Data->saveEncryptedLinkData(
                $EncryptLinkdata->getEncryptionKey(),
                $EncryptLinkdata->getEncryptedLinkData()
            );
            return $EncryptLinkdata->getEncryptionKey();
        } catch (\Exception $e) {

        }
    }

    public function getLink($key) {
        try {
            $data = $this->Data->getLinkDataRecord($key);

            $DecryptLinkdata = getService('entity.linkdata');
            $DecryptLinkdata->setupLinkdata($key, $data);

            if ($DecryptLinkdata->linkIsExpired()) {
                $this->Data->deleteLink($key);
            }
            return $DecryptLinkdata->decryptLink($data);
        } catch (\Exception $e) {

        }
    }
}