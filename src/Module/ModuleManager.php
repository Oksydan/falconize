<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Module;

use Oksydan\Falconize\PrestaShop\Module\PrestaShopModuleInterface;

class ModuleManager implements ModuleManagerInterface
{
    private PrestaShopModuleInterface $module;

    public function setModule(PrestaShopModuleInterface $module): void
    {
        $this->module = $module;
    }

    public function getModule(): PrestaShopModuleInterface
    {
        return $this->module;
    }
}
