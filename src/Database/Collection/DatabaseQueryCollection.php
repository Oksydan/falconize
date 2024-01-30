<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Collection;

use Oksydan\Falconize\Database\DTO\DatabaseQuery;

class DatabaseQueryCollection implements DatabaseQueryCollectionInterface, \IteratorAggregate
{
    private array $queries = [];

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->queries);
    }

    public function add(DatabaseQuery $query): void
    {
        $this->queries[] = $query;
    }

    public function toArray(): array
    {
        return $this->queries;
    }
}
