<?php
namespace App\Models;

use App\Helpers;

class LinkdataModel {
    /**
     * @var \App\Database\Linkdata
     */
    public $Data;

    public function __construct(\App\Database\Linkdata $Data) {
        $this->Data = $Data;
    }

    public function createLink($data) {
        try {
            $EncryptLinkdata = Helpers\getService('entity.linkdata');
            $EncryptLinkdata->encrypt($data);

            $this->Data->saveEncryptedLinkData(
                $EncryptLinkdata->getEncryptionKey(),
                $EncryptLinkdata->getEncryptedLinkData()
            );
            return $EncryptLinkdata->getEncryptionKey();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getLink($key) {
        try {
            $data = $this->Data->getLinkDataRecord($key);

            $DecryptLinkdata = Helpers\getService('entity.linkdata');
            $DecryptLinkdata->populate(['data_encrypted' => $data['data'], 'expires' => $data['expires']]);

            if ($DecryptLinkdata->linkIsExpired()) {
                $this->Data->deleteLink($key);
            }

            $DecryptLinkdata->decrypt($key);

            return $DecryptLinkdata->getDecryptedLinkData();

        } catch (\Exception $e) {

        }
    }
}