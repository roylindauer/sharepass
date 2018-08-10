<?php

namespace Royl\Sharepass\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Royl\Sharepass\Template;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AppController{

    /**
     * @var Template\AppTemplate
     */
    public $Template;

    /**
     * @var ContainerBuilder
     */
    public $Service;

    public function __construct() {
        $this->defineServices();
        $this->Template = $this->getService('app.template');
    }

    /**
     * @todo move outside of appcontroller
     */
    private function defineServices() {
        $this->Service = new ContainerBuilder();
        $this->Service
            ->register('app.template', '\Royl\Sharepass\Template\AppTemplate')
            ->setPublic(true);

        $this->Service
            ->register('app.dbconnection', '\Royl\Sharepass\Libraries\Db')
            ->setPublic(true);

        $this->Service
            ->register('data.linkdata', '\Royl\Sharepass\Data\Linkdata')
            ->addArgument(new Reference('app.dbconnection'))
            ->setPublic(true);

        $this->Service
            ->register('model.linkdata', '\Royl\Sharepass\Models\Linkdata')
            ->addArgument(new Reference('app.dbconnection'))
            ->addArgument(new Reference('data.linkdata'))
            ->setPublic(true);

        $this->Service->compile();
    }

    public function getService($service) {
        return $this->Service->get($service);
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