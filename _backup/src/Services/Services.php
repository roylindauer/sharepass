<?php

namespace App\Services;

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
            ->register('app.dbconnection', \App\Services\DbConnection::class)
            ->setPublic(true);

        $this->Service
            ->register('app.encrypt', \JaegerApp\Encrypt::class)
            ->setPublic(true);

        $this->Service
            ->register('database.linkdata', \App\Database\Linkdata::class)
            ->addArgument(new Reference('app.dbconnection'))
            ->setPublic(true);

        $this->Service
            ->register('model.linkdata', \App\Models\LinkdataModel::class)
            ->addArgument(new Reference('database.linkdata'))
            ->setPublic(true);

        $this->Service
            ->register('entity.linkdata', \App\Entities\LinkdataEntity::class)
            ->addArgument(new Reference('database.linkdata'))
            ->setPublic(true);

        $this->Service->compile();
    }

    public function get($service) {
        return $this->Service->get($service);
    }
}
