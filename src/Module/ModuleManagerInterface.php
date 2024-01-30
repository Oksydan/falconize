<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Module;

use Oksydan\Falconize\PrestaShop\Module\PrestaShopModuleInterface;

interface ModuleManagerInterface
{
    public function setModule(PrestaShopModuleInterface $connection): void;

    public function getModule(): PrestaShopModuleInterface;
}
