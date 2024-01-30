<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Comparator;

use Doctrine\DBAL\Schema\Comparator;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaDiff;

final class SchemaComparator implements SchemaComparatorInterface
{
    public function compare(Schema $fromSchema, Schema $toSchema): SchemaDiff
    {
        $comparator = new Comparator();

        return $comparator->compare($fromSchema, $toSchema);
    }
}
