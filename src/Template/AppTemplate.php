<?php
namespace App\Template;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

class AppTemplate {
    public $Templating;
    public $template = '';
    public $layout = '';
    public $variables = array();

    public function __construct() {
        $filesystemLoader = new FilesystemLoader(array(
            BASEDIR . '/templates/%name%'
        ));
        $this->setLayout('layout');
        $this->Templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);
    }

    public function render() {
        echo $this->Templating->render($this->getLayout(), array(
            'vars' => $this->getVars(),
            'view_template' => $this->getTemplate()
        ));
    }

    public function getVars() {
        return $this->variables;
    }

    public function setVar($var, $data) {
        $this->variables[$var] = $data;
    }

    public function getTemplate() {
        return $this->template;
    }

    public function setTemplate($template) {
        $this->template = 'views/' . $template . '.php';
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout($layout) {
        $this->layout = 'layouts/' . $layout . '.php';
    }
}