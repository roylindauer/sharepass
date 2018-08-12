<?php

namespace Royl\Sharepass\Controllers;

class LinkdataController extends AppController{

    public function __construct()
    {
        $this->Model = getService('model.linkdata');
        parent::__construct();
    }

    public function index() {
    }

    public function add() {
        $this->setVar('key', $this->Model->createLink($_POST['mydata']));
        $this->setView('index');
    }
    
    public function view(){
        $key = $this->getAttribute('key');
        $this->setVar('linkdata', $this->Model->getLink($key));
    }
}