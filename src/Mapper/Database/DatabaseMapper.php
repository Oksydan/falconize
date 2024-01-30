<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Mapper\Database;

use Oksydan\Falconize\Database\Collection\DatabaseObjectsCollection;
use Oksydan\Falconize\Database\DTO\Column;
use Oksydan\Falconize\Database\DTO\ColumnName;
use Oksydan\Falconize\Database\DTO\ForeignKeyConstraint;
use Oksydan\Falconize\Database\DTO\Index;
use Oksydan\Falconize\Database\DTO\PrimaryKey;
use Oksydan\Falconize\Database\DTO\Table;

final class DatabaseMapper implements DatabaseMapperInterface
{
    public function mapArrayToDatabaseCollection(array $array): DatabaseObjectsCollection
    {
        $collection = new DatabaseObjectsCollection();

        foreach ($array as $tableName => $tableData) {
            $collection->add($this->buildTable($tableName, $tableData));
        }

        return $collection;
    }

    private function buildTable(string $tableName, array $tableData): Table
    {
        $table = new Table($tableName);

        foreach ($tableData['columns'] as $columnData) {
            $table->addColumn($this->buildColumn($columnData));
        }

        if (isset($tableData['primary'])) {
            $table->addPrimaryKey($this->buildPrimaryKey($tableData['primary']));
        }

        if (isset($tableData['indexes'])) {
            foreach ($tableData['indexes'] as $indexData) {
                $table->addIndex($this->buildIndex($indexData));
            }
        }

        foreach ($tableData['constraint_keys'] as $foreignKeyData) {
            $table->addForeignKeyConstraint($this->buildForeignKeyConstraint($foreignKeyData));
        }

        return $table;
    }

    private function buildColumn(array $columnData): Column
    {
        $column = new Column($columnData['name'], $columnData['type']);

        if (isset($columnData['length'])) {
            $column->setLength($columnData['length']);
        }

        if (isset($columnData['notnull'])) {
            $column->setNotNull($columnData['notnull']);
        }

        if (isset($columnData['default'])) {
            $column->setDefault($columnData['default']);
        }

        if (isset($columnData['autoincrement'])) {
            $column->setAutoincrement($columnData['autoincrement']);
        }

        if (isset($columnData['unsigned'])) {
            $column->setUnsigned($columnData['unsigned']);
        }

        if (isset($columnData['fixed'])) {
            $column->setFixed($columnData['fixed']);
        }

        if (isset($columnData['precision'])) {
            $column->setPrecision($columnData['precision']);
        }

        if (isset($columnData['scale'])) {
            $column->setScale($columnData['scale']);
        }

        return $column;
    }

    private function buildPrimaryKey(array $primaryKeyColumns): PrimaryKey
    {
        $primaryKey = new PrimaryKey();

        foreach ($primaryKeyColumns as $primaryKeyColumn) {
            $primaryKey->addColumn((new ColumnName($primaryKeyColumn)));
        }

        return $primaryKey;
    }

    private function buildIndex(array $indexData): Index
    {
        $index = new Index($indexData['name']);

        foreach ($indexData['columns'] as $column) {
            $index->addColumn((new ColumnName($column)));
        }

        return $index;
    }

    private function buildForeignKeyConstraint(array $foreignKeyData): ForeignKeyConstraint
    {
        $foreignKeyConstraint = new ForeignKeyConstraint(
            $foreignKeyData['name'],
            $foreignKeyData['foreign_table'],
            $foreignKeyData['update'],
            $foreignKeyData['delete']
        );

        foreach ($foreignKeyData['local_columns'] as $localColumn) {
            $foreignKeyConstraint->addLocalColumn((new ColumnName($localColumn)));
        }

        foreach ($foreignKeyData['foreign_columns'] as $foreignColumn) {
            $foreignKeyConstraint->addForeignColumn((new ColumnName($foreignColumn)));
        }

        return $foreignKeyConstraint;
    }
}
