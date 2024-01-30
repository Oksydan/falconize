<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Database;

use Oksydan\Falconize\Exception\YamlFileException;

interface DatabaseValidatorInterface
{
    /**
     * @param array $array
     * @throws YamlFileException
     * @return void
     */
    public function validate(array $array): void;
}
