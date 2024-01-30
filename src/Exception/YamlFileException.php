<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Exception;

class YamlFileException extends \Exception
{
    public static function invalidTableName(): self
    {
        return new self('Invalid table configuration, your table name must be a string');
    }

    public static function invalidTableColumns(): self
    {
        return new self("Invalid table configuration, your table must contains 'columns'");
    }

    public static function invalidColumnMissingName(string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column must contains a name",
            $tableName
        ));
    }

    public static function invalidColumnMissingType(string $columnName, string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' must contains a type",
            $tableName,
            $columnName
        ));
    }

    public static function invalidColumnType(string $columnName, string $columnType, string $tableName, array $columnTypes): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' type: '%s' is invalid. Please use one of a type %s",
            $tableName,
            $columnName,
            $columnType,
            implode(', ', $columnTypes)
        ));
    }

    public static function invalidColumnLength(string $columnName, $length, string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' length: '%s' is invalid. Please use integer",
            $tableName,
            $columnName,
            $length
        ));
    }

    public static function invalidColumnPrecision(string $columnName, $precision, string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' precision: '%s' is invalid. Please use integer",
            $tableName,
            $columnName,
            $precision
        ));
    }

    public static function invalidColumnScale(string $columnName, $scale, string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' scale: '%s' is invalid. Please use integer",
            $tableName,
            $columnName,
            $scale
        ));
    }

    public static function invalidColumnUnsigned(string $columnName, $unsigned, string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' unsigned: '%s' is invalid. Please use boolean",
            $tableName,
            $columnName,
            $unsigned
        ));
    }

    public static function invalidColumnFixed(string $columnName, $fixed, string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' fixed: '%s' is invalid. Please use boolean",
            $tableName,
            $columnName,
            $fixed
        ));
    }

    public static function invalidColumnNotnull(string $columnName, $notnull, string $tableName): self
    {
        return new self(sprintf(
            "Invalid column configuration for table: '%s', your column '%s' notnull: '%s' is invalid. Please use boolean",
            $tableName,
            $columnName,
            $notnull
        ));
    }

    public static function invalidForeignKeyConstraintMissingName(string $tableName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint must contains a name",
            $tableName
        ));
    }

    public static function invalidForeignKeyConstraintMissingLocalColumns(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': must contains 'local_columns'",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidLocalColumns(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': 'local_columns' must be an array",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidLocalColumnsValue(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': 'local_columns' must be an array of strings",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintMissingForeignColumns(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s' must contains a 'foreign_columns'",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidForeignColumns(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': 'foreign_columns' must be an array",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidForeignColumnsValue(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': 'foreign_columns' must be an array of strings",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintMissingForeignTable(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s' must contains 'foreign_table'",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidForeignTable(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': 'foreign_table' must be a string",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidUpdate(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': 'update' must be a string",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidUpdateValue(string $tableName, string $constraintName, array $allowedActions): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your 'update' must be one of: " . implode(', ', $allowedActions),
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidDelete(string $tableName, string $constraintName): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your foreign key constraint '%s': 'delete' must be a string",
            $tableName,
            $constraintName
        ));
    }

    public static function invalidForeignKeyConstraintInvalidDeleteValue(string $tableName, string $constraintName, array $allowedActions): self
    {
        return new self(sprintf(
            "Invalid foreign key constraint configuration for table: '%s', your 'delete' must be one of: " . implode(', ', $allowedActions),
            $tableName,
            $constraintName
        ));
    }

    public static function invalidIndexMissingName(string $tableName): self
    {
        return new self(sprintf(
            "Invalid index configuration for table: '%s', your index must contains a 'name'",
            $tableName
        ));
    }

    public static function invalidIndexMissingColumns(string $tableName, string $indexName): self
    {
        return new self(sprintf(
            "Invalid index for table: '%s', your index '%s' must contains 'columns'",
            $tableName,
            $indexName
        ));
    }

    public static function invalidIndexInvalidColumns(string $tableName, string $indexName): self
    {
        return new self(sprintf(
            "Invalid index for table: '%s', your index '%s': 'columns' must be an array",
            $tableName,
            $indexName
        ));
    }

    public static function invalidIndexInvalidColumnsValue(string $tableName, string $indexName): self
    {
        return new self(sprintf(
            "Invalid index for table: '%s', your index '%s': 'columns' must be an array of strings",
            $tableName,
            $indexName
        ));
    }

    public static function invalidPrimaryKeyInvalidValue(string $tableName): self
    {
        return new self(sprintf(
            "Invalid primary key for table: '%s', primary key value must be an array of strings",
            $tableName,
        ));
    }

    public static function invalidHooksEmptyValue(): self
    {
        return new self("Invalid hooks configuration, your hooks must contains a 'register' or 'unregister'");
    }

    public static function invalidHooksValue($type): self
    {
        return new self(sprintf(
            "Invalid hooks configuration, your hooks '%s' must be an array",
            $type,
        ));
    }

    public static function invalidHookValue(): self
    {
        return new self('Invalid hook configuration, your hook must be a string or an array');
    }

    public static function invalidHookName(): self
    {
        return new self('Invalid hook configuration, your hook name must be a string');
    }

    public static function invalidHookVersion($hookName): self
    {
        return new self(sprintf(
            "Invalid hook configuration, your hook: '%s' 'version' must be a string",
            $hookName,
        ));
    }

    public static function invalidHookVersionCompare($hookName): self
    {
        return new self(sprintf(
            "Invalid hook configuration, your hook: '%s' 'version_compare' must be a string",
            $hookName,
        ));
    }

    public static function invalidHookVersionCompareValue($hookName, array $operationsList): self
    {
        return new self(sprintf(
            "Invalid hook configuration, your hook: '%s' 'version_compare' must be a one of: %s",
            $hookName,
            implode(', ', $operationsList)
        ));
    }
}
