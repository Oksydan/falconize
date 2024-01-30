<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Database;

use Oksydan\Falconize\Exception\YamlFileException;

final class DatabaseValidator implements DatabaseValidatorInterface
{
    private ValidateColumn $validateColumn;

    private ValidateIndex $validateIndex;

    private ValidatePrimaryKey $validatePrimaryKey;

    private ValidateForeignKeyConstraint $validateForeignKeyConstraint;

    public function __construct(
        ValidateColumn $validateColumn,
        ValidateIndex $validateIndex,
        ValidatePrimaryKey $validatePrimaryKey,
        ValidateForeignKeyConstraint $validateForeignKeyConstraint
    ) {
        $this->validateColumn = $validateColumn;
        $this->validateIndex = $validateIndex;
        $this->validatePrimaryKey = $validatePrimaryKey;
        $this->validateForeignKeyConstraint = $validateForeignKeyConstraint;
    }

    public function validate(array $array): void
    {
        foreach ($array as $tableName => $table) {
            if (!is_string($tableName)) {
                throw YamlFileException::invalidTableName();
            }

            if (empty($table['columns']) || !is_array($table['columns'])) {
                throw YamlFileException::invalidTableColumns();
            }

            foreach ($table['columns'] as $column) {
                $this->validateColumn->validate($column, $tableName);
            }

            if (isset($table['indexes'])) {
                foreach ($table['indexes'] as $index) {
                    $this->validateIndex->validate($index, $tableName);
                }
            }

            if (isset($table['primary_key'])) {
                $this->validatePrimaryKey->validate($table['primary'], $tableName);
            }

            if (isset($table['foreign_key_constraints'])) {
                foreach ($table['foreign_key_constraints'] as $foreignKeyConstraint) {
                    $this->validateForeignKeyConstraint->validate($foreignKeyConstraint, $tableName);
                }
            }
        }
    }
}
