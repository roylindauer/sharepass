<?php

namespace Royl\Sharepass\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Royl\Sharepass\Db;
use Royl\Sharepass\Template;

class AppController{
    public $DB;

    public function __construct() {
        $this->DB = new Db\Db();
        $this->Template = new Template\AppTemplate();
    }

    public function setVar($var, $data) {
        $this->Template->setVar($var, $data);
    }

    public function setTemplate($template) {
        $this->Template->setTemplate($template);
    }

    public function render() {
        return new Response($this->Template->render());
    }
}