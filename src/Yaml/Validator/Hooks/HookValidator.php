<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Hooks;

use Oksydan\Falconize\Exception\YamlFileException;

final class HookValidator implements HookValidatorInterface
{
    private const VERSION_COMPARE_OPERATORS = ['<', '<=', '>', '>=', '==', '!='];

    public function validate($hook, $hookName): void
    {
        if ((!is_string($hook) && !is_array($hook)) || empty($hook)) {
            throw YamlFileException::invalidHookValue();
        }

        if (is_array($hook)) {
            if (!is_string($hookName)) {
                throw YamlFileException::invalidHookName();
            }

            if (empty($hook['version']) || !is_string($hook['version'])) {
                throw YamlFileException::invalidHookVersion($hookName);
            }

            if (empty($hook['version_compare']) || !is_string($hook['version_compare'])) {
                throw YamlFileException::invalidHookVersionCompare($hookName);
            }

            if (!in_array($hook['version_compare'], self::VERSION_COMPARE_OPERATORS, true)) {
                throw YamlFileException::invalidHookVersionCompareValue($hookName, self::VERSION_COMPARE_OPERATORS);
            }
        }
    }
}
