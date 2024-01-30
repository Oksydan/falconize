<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Mapper\Database;

use Oksydan\Falconize\Database\Collection\DatabaseObjectsCollection;

interface DatabaseMapperInterface
{
    public function mapArrayToDatabaseCollection(array $array): DatabaseObjectsCollection;
}
