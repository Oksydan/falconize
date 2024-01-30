<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Hooks;

use Oksydan\Falconize\Exception\YamlFileException;

interface HooksValidatorInterface
{
    /**
     * @param array $hooks
     * @throws YamlFileException
     * @return void
     */
    public function validate(array $hooks): void;
}
