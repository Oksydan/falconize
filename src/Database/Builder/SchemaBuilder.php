<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Builder;

use Doctrine\DBAL\Schema\Schema;
use Oksydan\Falconize\Database\DTO\Column;
use Oksydan\Falconize\Database\DTO\ForeignKeyConstraint;
use Oksydan\Falconize\Database\DTO\Index;
use Oksydan\Falconize\Database\DTO\PrimaryKey;
use Oksydan\Falconize\Database\DTO\Table;
use Oksydan\Falconize\Helper\TableNameFormatter;

final class SchemaBuilder implements SchemaBuilderInterface
{
    private TableNameFormatter $tableNameFormatter;

    public function __construct(TableNameFormatter $tableNameFormatter)
    {
        $this->tableNameFormatter = $tableNameFormatter;
    }

    public function build(Table $table): Schema
    {
        $schema = new Schema();
        $dbTable = $schema->createTable($this->tableNameFormatter->getFullTableName($table->getName()));

        /* @var Column $column */
        foreach ($table->getColumns() as $column) {
            $dbTable->addColumn($column->getName(), $column->getType(), $column->getOptions());
        }

        /* @var PrimaryKey $primaryKey */
        foreach ($table->getPrimaryKeys() as $primaryKey) {
            $dbTable->setPrimaryKey($primaryKey->getColumns());
        }

        /* @var Index $index */
        foreach ($table->getIndexes() as $index) {
            $dbTable->addIndex($index->getColumns(), $index->getName());
        }

        /* @var ForeignKeyConstraint $foreignKey */
        foreach ($table->getForeignKeysConstraint() as $foreignKey) {
            $constraintsIndexName = $foreignKey->getName() . '_index';

            $dbTable->addIndex($foreignKey->getLocalColumns(), $constraintsIndexName);

            $dbTable->addForeignKeyConstraint(
                $this->tableNameFormatter->getFullTableName($foreignKey->getForeignTableName()),
                $foreignKey->getLocalColumns(),
                $foreignKey->getForeignColumns(),
                $foreignKey->getOptions(),
                $foreignKey->getName()
            );
        }

        return $schema;
    }
}
