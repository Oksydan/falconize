<?php

namespace Oksydan\Falconize;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Container extends ContainerBuilder
{
    public function __construct()
    {
        parent::__construct();

        $loader = new YamlFileLoader($this, new FileLocator(__DIR__));
        $loader->load('../config/services.yml');

        $this->compile();
    }
}
