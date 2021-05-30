<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Template;

class AppController{

    private $action;
    private $Request;
    private $Template;

    public function __construct() {
        $this->Template = new Template\AppTemplate();
    }

    public function invoke(Request $Request): Response {
        try {
            $this->Request = $Request;
            $this->action = $this->getAttribute('_action');

            $this->setView();

            if (!method_exists($this, $this->action)) {
                throw new \Exception(sprintf('Method does not exist: %s', $this->action));
            }

            $callable = [$this, $this->action];
            $callable();
            return $this->render();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getAttribute($var) {
        return $this->Request->attributes->get($var);
    }

    public function setView($override_action = false) {
        $action = ($override_action) ? $override_action : $this->action;
        $this->Template->setTemplate($action);
    }

    public function setVar($var, $data) {
        $this->Template->setVar($var, $data);
    }

    public function render() {
        return new Response($this->Template->render());
    }
}