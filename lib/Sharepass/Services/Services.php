<?php

namespace Royl\Sharepass\Services;

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
            ->register('app.dbconnection', '\Royl\Sharepass\Services\DbConnection')
            ->setPublic(true);

        $this->Service
            ->register('app.encrypt', '\JaegerApp\Encrypt')
            ->setPublic(true);

        $this->Service
            ->register('database.linkdata', '\Royl\Sharepass\Database\Linkdata')
            ->addArgument(new Reference('app.dbconnection'))
            ->setPublic(true);

        $this->Service
            ->register('model.linkdata', '\Royl\Sharepass\Models\LinkdataModel')
            ->addArgument(new Reference('database.linkdata'))
            ->setPublic(true);

        $this->Service
            ->register('entity.linkdata', '\Royl\Sharepass\Entities\LinkdataEntity')
            ->addArgument(new Reference('database.linkdata'))
            ->setPublic(true);

        $this->Service->compile();
    }

    public function get($service) {
        return $this->Service->get($service);
    }
}
