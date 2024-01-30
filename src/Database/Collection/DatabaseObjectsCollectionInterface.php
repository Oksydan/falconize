<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Collection;

use Oksydan\Falconize\Database\DTO\DatabaseObjectInterface;

interface DatabaseObjectsCollectionInterface
{
    public function add(DatabaseObjectInterface $databaseObject): void;

    public function getIterator(): \Traversable;
}
