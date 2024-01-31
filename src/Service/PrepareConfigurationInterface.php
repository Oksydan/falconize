<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Service;

use Oksydan\Falconize\FalconizeConfigurationInterface;

interface PrepareConfigurationInterface
{
    public function prepare(FalconizeConfigurationInterface $configuration): void;
}
