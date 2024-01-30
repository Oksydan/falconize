<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Database;

use Doctrine\DBAL\Types\Type;
use Oksydan\Falconize\Exception\YamlFileException;

final class ValidateColumn implements DatabaseElementValidatorInterface
{
    public function validate(array $element, string $tableName): void
    {
        if (empty($element['name'])) {
            throw YamlFileException::invalidColumnMissingName($tableName);
        }

        if (empty($element['type'])) {
            throw YamlFileException::invalidColumnMissingType($element['name'], $tableName);
        }

        $columnTypes = array_keys(Type::getTypesMap());

        if (!in_array($element['type'], $columnTypes)) {
            throw YamlFileException::invalidColumnType($element['name'], $tableName, $element['type'], $columnTypes);
        }

        if (!empty($element['length']) && !is_int($element['length'])) {
            throw YamlFileException::invalidColumnLength($element['name'], $element['length'], $tableName);
        }

        if (!empty($element['precision']) && !is_int($element['precision'])) {
            throw YamlFileException::invalidColumnPrecision($element['name'], $element['precision'], $tableName);
        }

        if (!empty($element['scale']) && !is_int($element['scale'])) {
            throw YamlFileException::invalidColumnScale($element['name'], $element['scale'], $tableName);
        }

        if (!empty($element['unsigned']) && !is_bool($element['unsigned'])) {
            throw YamlFileException::invalidColumnUnsigned($element['name'], $element['unsigned'], $tableName);
        }

        if (!empty($element['fixed']) && !is_bool($element['fixed'])) {
            throw YamlFileException::invalidColumnFixed($element['name'], $element['fixed'], $tableName);
        }

        if (!empty($element['notnull']) && !is_bool($element['notnull'])) {
            throw YamlFileException::invalidColumnNotnull($element['name'], $element['notnull'], $tableName);
        }
    }
}
