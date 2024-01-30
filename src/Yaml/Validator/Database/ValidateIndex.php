<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Database;

use Oksydan\Falconize\Exception\YamlFileException;

final class ValidateIndex implements DatabaseElementValidatorInterface
{
    public function validate(array $element, string $tableName): void
    {
        if (empty($element['name'])) {
            throw YamlFileException::invalidIndexMissingName($tableName);
        }

        if (empty($element['columns'])) {
            throw YamlFileException::invalidIndexMissingColumns($tableName, $element['name']);
        }

        if (!is_array($element['columns'])) {
            throw YamlFileException::invalidIndexInvalidColumns($tableName, $element['name']);
        }

        foreach ($element['columns'] as $column) {
            if (!is_string($column)) {
                throw YamlFileException::invalidIndexInvalidColumnsValue($tableName, $element['name']);
            }
        }
    }
}
