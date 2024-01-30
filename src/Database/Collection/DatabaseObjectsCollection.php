<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Collection;

use Oksydan\Falconize\Database\DTO\DatabaseObjectInterface;

class DatabaseObjectsCollection implements DatabaseObjectsCollectionInterface, \IteratorAggregate
{
    private array $objects = [];

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->objects);
    }

    public function add(DatabaseObjectInterface $databaseObject): void
    {
        $this->objects[] = $databaseObject;
    }

    public function toArray(): array
    {
        return $this->objects;
    }
}
