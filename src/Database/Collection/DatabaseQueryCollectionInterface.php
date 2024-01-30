<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Collection;

use Oksydan\Falconize\Database\DTO\DatabaseQuery;

interface DatabaseQueryCollectionInterface
{
    public function add(DatabaseQuery $databaseObject): void;

    public function getIterator(): \Traversable;
}
