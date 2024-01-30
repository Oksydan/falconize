<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Database;

use Oksydan\Falconize\Exception\YamlFileException;

final class ValidatePrimaryKey implements DatabaseElementValidatorInterface
{
    public function validate(array $element, string $tableName): void
    {
        foreach ($element as $column) {
            if (!is_string($column)) {
                throw YamlFileException::invalidPrimaryKeyInvalidValue($tableName);
            }
        }
    }
}
