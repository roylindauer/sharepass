<?php

namespace Royl\Sharepass\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Royl\Sharepass\Data;
use Royl\Sharepass\Libraries\EncryptLink;
use Royl\Sharepass\Libraries\DecryptLink;

class LinkdataController extends AppController{

    public function index(Request $request) {
        $this->setTemplate('index');
        return $this->render();
    }

    public function add(Request $request) {
        $Model = get_service('model.linkdata');
        $this->setVar('key', $Model->createLink($_POST['mydata']));
        $this->setTemplate('index');
        return $this->render();
    }
    
    public function view(Request $request, $key){
        $Model = get_service('model.linkdata');
        $this->setVar('linkdata', $Model->getLink($key));
        $this->setTemplate('view');
        return $this->render();
    }
}