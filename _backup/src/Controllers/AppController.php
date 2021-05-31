<?php

namespace App\Controllers;

use App\Kernel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

class AppController{

    private $action;
    private $Request;

    public function __construct() {
    }

    public function invoke(Request $Request) {
        try {
            $this->Request = $Request;
            $this->action = $this->getAttribute('_action');

            if (!method_exists($this, $this->action)) {
                throw new \Exception(sprintf('Method does not exist: %s', $this->action));
            }

            $callable = [$this, $this->action];
            return $callable();

        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getAttribute($var) {
        return $this->Request->attributes->get($var);
    }

    public function render($view = null, $vars = []){

        $view = ( $view != null ) ? $view : $this->action;
        $view = 'views/' . $view . '.php';

        $filesystemLoader = new FilesystemLoader(array(
            BASEDIR . '/templates/%name%'
        ));

        $this->Templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);

        $result = $this->Templating->render('layouts/layout.php', array(
            'vars' => $vars,
            'view_template' => $view
        ));

        return new Response($result);
    }
}