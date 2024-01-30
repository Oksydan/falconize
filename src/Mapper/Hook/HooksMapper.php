<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Mapper\Hook;

use Oksydan\Falconize\Hook\Collection\HookCollection;
use Oksydan\Falconize\Hook\DTO\Hook;

class HooksMapper implements HooksMapperInterface
{
    public function mapArrayToHookCollection(array $array): HookCollection
    {
        $hookCollection = new HookCollection();

        foreach ($array as $hookKey => $hook) {
            if (!is_array($hook)) {
                $hookCollection->add($this->buildHook($hook, null));
            } else {
                $hookCollection->add($this->buildHook($hookKey, $hook));
            }
        }

        return $hookCollection;
    }

    private function buildHook(string $hookName, ?array $hook): Hook
    {
        $hookDto = new Hook($hookName);

        if ($hook) {
            $hookDto->setVersion($hook['version']);
            $hookDto->setVersionCompare($hook['version_compare']);
        }

        return $hookDto;
    }
}
