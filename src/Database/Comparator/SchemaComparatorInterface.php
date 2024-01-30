<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Comparator;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaDiff;

interface SchemaComparatorInterface
{
    public function compare(Schema $fromSchema, Schema $toSchema): SchemaDiff;
}
