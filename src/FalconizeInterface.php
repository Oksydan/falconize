<?php

declare(strict_types=1);

namespace Oksydan\Falconize;

interface FalconizeInterface
{
    public function install(int $onException);

    public function uninstall(int $onException);
}
