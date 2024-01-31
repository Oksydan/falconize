<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\Executor;

use Oksydan\Falconize\Exception\HookRegisterException;
use Oksydan\Falconize\Hook\Collection\HookCollection;
use Oksydan\Falconize\Module\ModuleManager;

final class ModuleHookRegisterExecutor implements ModuleHookExecutorInterface
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
     * @throws HookRegisterException
     */
    public function execute(HookCollection $hookCollection): void
    {
        $module = $this->moduleManager->getModule();

        foreach ($hookCollection as $hook) {
            try {
                $module->registerHook(
                    $hook->getName(),
                );
            } catch (\Exception $e) {
                throw new HookRegisterException($e->getMessage());
            }
        }
    }
}
