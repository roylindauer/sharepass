<?php

namespace App\Controllers;

class LinkdataController extends AppController{

    public $Model = null;

    public function __construct()
    {
        $this->Model = \get_service('model.linkdata');
        parent::__construct();
    }

    public function index() {
        return $this->render('index');
    }

    public function add() {
        return $this->render('index', ['key' => $this->Model->createLink($_POST['mydata'])]);
    }

    public function view() {
        return $this->render('view', ['linkdata' => $this->Model->getLink($this->getAttribute('key'))]);
    }
}