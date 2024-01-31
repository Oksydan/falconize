<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\Executor;

use Oksydan\Falconize\Exception\HookUnregisterException;
use Oksydan\Falconize\Hook\Collection\HookCollection;
use Oksydan\Falconize\Module\ModuleManager;

final class ModuleHookUnregisterExecutor implements ModuleHookExecutorInterface
{
    private ModuleManager $moduleManager;

    public function __construct(
        ModuleManager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @param HookCollection $hookCollection
     * @return void
     * @throws HookUnregisterException
     */
    public function execute(HookCollection $hookCollection): void
    {
        $module = $this->moduleManager->getModule();

        foreach ($hookCollection as $hook) {
            try {
                $module->unregisterHook(
                    $hook->getName()
                );
            } catch (\Exception $e) {
                throw new HookUnregisterException($e->getMessage());
            }
        }
    }
}
