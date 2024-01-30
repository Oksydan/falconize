<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Database;

use Oksydan\Falconize\Exception\YamlFileException;

final class ValidateForeignKeyConstraint implements DatabaseElementValidatorInterface
{
    private const ALLOWED_ACTIONS = ['NO ACTION', 'CASCADE', 'SET NULL', 'RESTRICT', 'SET DEFAULT'];

    public function validate(array $element, string $tableName): void
    {
        if (empty($element['name'])) {
            throw YamlFileException::invalidForeignKeyConstraintMissingName($tableName);
        }

        if (empty($element['local_columns'])) {
            throw YamlFileException::invalidForeignKeyConstraintMissingLocalColumns($tableName, $element['name']);
        }

        if (!is_array($element['local_columns'])) {
            throw YamlFileException::invalidForeignKeyConstraintInvalidLocalColumns($tableName, $element['name']);
        }

        foreach ($element['local_columns'] as $column) {
            if (!is_string($column)) {
                throw YamlFileException::invalidForeignKeyConstraintInvalidLocalColumnsValue($tableName, $element['name']);
            }
        }

        if (empty($element['foreign_columns'])) {
            throw YamlFileException::invalidForeignKeyConstraintMissingForeignColumns($tableName, $element['name']);
        }

        if (!is_array($element['foreign_columns'])) {
            throw YamlFileException::invalidForeignKeyConstraintInvalidForeignColumns($tableName, $element['name']);
        }

        foreach ($element['foreign_columns'] as $column) {
            if (!is_string($column)) {
                throw YamlFileException::invalidForeignKeyConstraintInvalidForeignColumnsValue($tableName, $element['name']);
            }
        }

        if (empty($element['foreign_table'])) {
            throw YamlFileException::invalidForeignKeyConstraintMissingForeignTable($tableName, $element['name']);
        }

        if (!is_string($element['foreign_table'])) {
            throw YamlFileException::invalidForeignKeyConstraintInvalidForeignTable($tableName, $element['name']);
        }

        if (!empty($element['update']) && !is_string($element['update'])) {
            throw YamlFileException::invalidForeignKeyConstraintInvalidUpdate($tableName, $element['name']);
        }

        if (!empty($element['update']) && !in_array($element['update'], self::ALLOWED_ACTIONS)) {
            throw YamlFileException::invalidForeignKeyConstraintInvalidUpdateValue($tableName, $element['name'], self::ALLOWED_ACTIONS);
        }

        if (!empty($element['delete']) && !is_string($element['delete'])) {
            throw YamlFileException::invalidForeignKeyConstraintInvalidDelete($tableName, $element['name']);
        }

        if (!empty($element['delete']) && !in_array($element['delete'], self::ALLOWED_ACTIONS)) {
            throw YamlFileException::invalidForeignKeyConstraintInvalidDeleteValue($tableName, $element['name'], self::ALLOWED_ACTIONS);
        }
    }
}
