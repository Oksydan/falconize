<?php

namespace Oksydan\Falconize;

use Doctrine\DBAL\Connection;
use Oksydan\Falconize\PrestaShop\Module\PrestaShopModuleInterface;

interface FalconizeConfigurationInterface
{
    public function getConnection(): Connection;

    public function getModule(): PrestaShopModuleInterface;

    public function getConfigurationFile(): \SplFileInfo;

    public function getDatabasePrefix(): string;

    public function getPrestashopVersion(): string;
}
