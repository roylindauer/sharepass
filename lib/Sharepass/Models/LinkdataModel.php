<?php
namespace Royl\Sharepass\Models;

use Royl\Sharepass\Services;

class LinkdataModel {
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

            $EncryptLinkdata->encrypt($data);

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
            $DecryptLinkdata->setEncryptionKey($key);
            $DecryptLinkdata->populate($data);

            if ($DecryptLinkdata->linkIsExpired()) {
                $this->Data->deleteLink($key);
            }

            $encrypt = getService('app.encrypt');
            $encrypt->setKey($this->getEncryptionKey());

            $DecryptLinkdata->setRawLinkData($encrypt->decode($DecryptLinkdata->getEncryptedLinkData()));
            return $DecryptLinkdata->sanitizeRawLinkdata();
        } catch (\Exception $e) {

        }
    }
}