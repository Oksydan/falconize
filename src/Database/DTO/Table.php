<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\DTO;

use Oksydan\Falconize\Database\Collection\DatabaseObjectsCollection;

class Table implements DatabaseObjectInterface
{
    private string $name;

    private DatabaseObjectsCollection $columns;

    private DatabaseObjectsCollection $indexes;

    private DatabaseObjectsCollection $primaryKeys;

    private DatabaseObjectsCollection $foreignKeys;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
        $this->columns = new DatabaseObjectsCollection();
        $this->indexes = new DatabaseObjectsCollection();
        $this->primaryKeys = new DatabaseObjectsCollection();
        $this->foreignKeys = new DatabaseObjectsCollection();
    }

    public function addColumn(Column $column): void
    {
        $this->columns->add($column);
    }

    public function addIndex(Index $index): void
    {
        $this->indexes->add($index);
    }

    public function addPrimaryKey(PrimaryKey $primaryKey): void
    {
        $this->primaryKeys->add($primaryKey);
    }

    public function addForeignKeyConstraint(ForeignKeyConstraint $foreignKey): void
    {
        $this->foreignKeys->add($foreignKey);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColumns(): DatabaseObjectsCollection
    {
        return $this->columns;
    }

    public function getIndexes(): DatabaseObjectsCollection
    {
        return $this->indexes;
    }

    public function getPrimaryKeys(): DatabaseObjectsCollection
    {
        return $this->primaryKeys;
    }

    public function getForeignKeysConstraint(): DatabaseObjectsCollection
    {
        return $this->foreignKeys;
    }
}
