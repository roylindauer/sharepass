<?php

namespace Royl\Sharepass\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Royl\Sharepass\Db;
use Royl\Sharepass\Libraries;

class LinkdataController extends AppController{
    public function __construct() {
        parent::__construct();
        $this->DbLinkdata = new Db\DbLinkdata($this->DB);
    }

    public function index(Request $request){
        $EncryptLink = new \Royl\Sharepass\Libraries\EncryptLink($this->DbLinkdata);
        
        if ($request->getMethod() === 'POST') {
            $this->setVar('key', $EncryptLink->getNewLinkKey(filter_var($_POST['mydata'])));
        }

        $this->setTemplate('index');
        return $this->render();
    }
    
    public function view(Request $request, $key){
        $DecryptLink = new \Royl\Sharepass\Libraries\DecryptLink($this->DbLinkdata);
        $this->setVar('linkdata', $DecryptLink->getLinkData($key));
        $this->setTemplate('view');
        return $this->render();
    }
}