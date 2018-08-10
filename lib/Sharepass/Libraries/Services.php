<?php

namespace Royl\Sharepass\Libraries;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Services {
    /**
     * @var ContainerBuilder
     */
    public $Service;

    public function __construct() {
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

    public function get($service) {
        return $this->Service->get($service);
    }
}
