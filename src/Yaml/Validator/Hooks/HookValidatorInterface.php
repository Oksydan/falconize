<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Hooks;

use Oksydan\Falconize\Exception\YamlFileException;

interface HookValidatorInterface
{
    /**
     * @param array $hook
     * @throws YamlFileException
     * @return void
     */
    public function validate($hook): void;
}
