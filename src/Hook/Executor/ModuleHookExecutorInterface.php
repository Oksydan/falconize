<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\Executor;

use Oksydan\Falconize\Hook\Collection\HookCollection;

interface ModuleHookExecutorInterface
{
    public function execute(HookCollection $hookCollection): void;
}
