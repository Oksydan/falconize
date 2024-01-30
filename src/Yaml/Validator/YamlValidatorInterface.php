<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator;

use Oksydan\Falconize\Exception\YamlFileException;

interface YamlValidatorInterface
{
    /**
     * @param array|null $configuration
     * @return void
     * @throws YamlFileException
     */
    public function validate(?array $configuration): void;
}
