<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\DTO;

use Oksydan\Falconize\Database\Collection\DatabaseObjectsCollection;

class PrimaryKey implements DatabaseObjectInterface
{
    private DatabaseObjectsCollection $columns;

    public function __construct()
    {
        $this->columns = new DatabaseObjectsCollection();
    }

    public function addColumn(ColumnName $column): void
    {
        $this->columns->add($column);
    }

    /**
     * Array of column names
     * @return array<string>
     */
    public function getColumns(): array
    {
        return array_map(function (ColumnName $column) {
            return $column->getName();
        }, $this->columns->toArray());
    }
}
