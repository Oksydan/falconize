<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Hooks;

use Oksydan\Falconize\Exception\YamlFileException;

final class HookValidator implements HookValidatorInterface
{
    private const VERSION_COMPARE_OPERATORS = ['<', '<=', '>', '>=', '==', '!='];

    public function validate($hook): void
    {
        if ((!is_array($hook)) || empty($hook)) {
            throw YamlFileException::invalidHookValue();
        }

        if (!is_string($hook['name'])) {
            throw YamlFileException::invalidHookName();
        }

        if (!empty($hook['version']) && !is_string($hook['version'])) {
            throw YamlFileException::invalidHookVersion($hook['name']);
        }

        if (!empty($hook['compare_operator']) && !is_string($hook['compare_operator'])) {
            throw YamlFileException::invalidHookVersionCompare($hook['name']);
        }

        if (!empty($hook['compare_operator']) && !in_array($hook['compare_operator'], self::VERSION_COMPARE_OPERATORS, true)) {
            throw YamlFileException::invalidHookVersionCompareValue($hook['name'], self::VERSION_COMPARE_OPERATORS);
        }
    }
}
