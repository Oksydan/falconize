<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\DTO;

use Oksydan\Falconize\Database\Collection\DatabaseObjectsCollection;

class ForeignKeyConstraint implements DatabaseObjectInterface
{
    private string $name;

    private string $foreignTableName;

    private string $onUpdate;

    private string $onDelete;

    private DatabaseObjectsCollection $localColumns;

    private DatabaseObjectsCollection $foreignColumns;

    public function __construct(
        string $name,
        string $foreignTableName,
        string $onUpdate = 'NO ACTION',
        string $onDelete = 'NO ACTION'
    ) {
        $this->name = $name;
        $this->foreignTableName = $foreignTableName;
        $this->onUpdate = $onUpdate;
        $this->onDelete = $onDelete;
        $this->localColumns = new DatabaseObjectsCollection();
        $this->foreignColumns = new DatabaseObjectsCollection();
    }

    public function addLocalColumn(ColumnName $column): void
    {
        $this->localColumns->add($column);
    }

    public function addForeignColumn(ColumnName $column): void
    {
        $this->foreignColumns->add($column);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getForeignTableName(): string
    {
        return $this->foreignTableName;
    }

    public function getOnUpdate(): string
    {
        return $this->onUpdate;
    }

    public function getOnDelete(): string
    {
        return $this->onDelete;
    }

    /**
     * Array of column names
     * @return array<string>
     */
    public function getLocalColumns(): array
    {
        return array_map(function (ColumnName $column) {
            return $column->getName();
        }, $this->localColumns->toArray());
    }

    /**
     * Array of column names
     * @return array<string>
     */
    public function getForeignColumns(): array
    {
        return array_map(function (ColumnName $column) {
            return $column->getName();
        }, $this->foreignColumns->toArray());
    }

    /**
     * @return array<string, string>
     */
    public function getOptions(): array
    {
        return [
            'onUpdate' => $this->onUpdate,
            'onDelete' => $this->onDelete,
        ];
    }
}
