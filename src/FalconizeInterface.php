<?php

declare(strict_types=1);

namespace Oksydan\Falconize;

interface FalconizeInterface
{
    public function install();

    public function update();

    public function uninstall();
}
