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

        foreach ($array as $hook) {
            $hookCollection->add($this->buildHook($hook));
        }

        return $hookCollection;
    }

    private function buildHook(array $hook): Hook
    {
        $hookDto = new Hook($hook['name']);

        if ($hook) {
            $hookDto->setVersion($hook['version']);
            $hookDto->setCompareOperator($hook['compare_operator']);
        }

        return $hookDto;
    }
}
