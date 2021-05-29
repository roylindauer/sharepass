<?php

namespace Royl\Sharepass\Controllers;

use Royl\Sharepass\Helpers;
use Symfony\Component\Routing\Annotation\Route;

class LinkdataController extends AppController{

    public function __construct()
    {
        $this->Model = Helpers\getService('model.linkdata');
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