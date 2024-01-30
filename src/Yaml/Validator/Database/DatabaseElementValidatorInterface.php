<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Database;

use Oksydan\Falconize\Exception\YamlFileException;

interface DatabaseElementValidatorInterface
{
    /**
     * @param array $element
     * @param string $tableName
     * @throws YamlFileException
     * @return void
     */
    public function validate(array $element, string $tableName): void;
}
