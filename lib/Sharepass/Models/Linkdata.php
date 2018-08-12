<?php
namespace Royl\Sharepass\Models;

use Royl\Sharepass\Libraries;

class Linkdata {

    /**
     * @var \Royl\Sharepass\Libraries\Db
     */
    public $DBConnection;

    /**
     * @var \Royl\Sharepass\Data\Linkdata
     */
    public $Data;

    public function __construct(\Royl\Sharepass\Data\Linkdata $Data) {
        $this->Data = $Data;
    }

    public function createLink($data) {
        try {
            $EncryptLinkdata = get_service('lib.encrypt_linkdata');
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

            $DecryptLinkdata = get_service('lib.decrypt_linkdata');
            $DecryptLinkdata->setupLinkdata($key, $data);

            if ($DecryptLinkdata->linkIsExpired()) {
                $this->Data->deleteLink($key);
            }
            return $DecryptLinkdata->decryptLink($data);
        } catch (\Exception $e) {

        }
    }
}