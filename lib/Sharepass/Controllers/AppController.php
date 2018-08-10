<?php

namespace Royl\Sharepass\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Royl\Sharepass\Template;

class AppController{

    /**
     * @var Template\AppTemplate
     */
    public $Template;

    /**
     * @var
     */
    public $Service;

    /**
     * AppController constructor.
     */
    public function __construct() {
        $this->Template = get_service('app.template');
    }

    /**
     * @param $var
     * @param $data
     */
    public function setVar($var, $data) {
        $this->Template->setVar($var, $data);
    }

    /**
     * @param $template
     */
    public function setTemplate($template) {
        $this->Template->setTemplate($template);
    }

    public function render() {
        return new Response($this->Template->render());
    }
}