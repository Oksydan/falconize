<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\Collection;

use Oksydan\Falconize\Hook\DTO\HookInterface;

interface HookCollectionInterface
{
    public function add(HookInterface $hook): void;

    public function getIterator(): \Traversable;
}
