<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\Collection;

use Oksydan\Falconize\Hook\DTO\HookInterface;

class HookCollection implements HookCollectionInterface, \IteratorAggregate
{
    private array $hooks = [];

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->hooks);
    }

    public function add(HookInterface $hook): void
    {
        $this->hooks[] = $hook;
    }

    public function toArray(): array
    {
        return $this->hooks;
    }
}
