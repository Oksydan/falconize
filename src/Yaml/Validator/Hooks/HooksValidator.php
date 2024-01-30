<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator\Hooks;

use Oksydan\Falconize\Exception\YamlFileException;

final class HooksValidator implements HooksValidatorInterface
{
    private HookValidator $hookValidator;

    public function __construct(HookValidator $hookValidator)
    {
        $this->hookValidator = $hookValidator;
    }

    public function validate(array $hooks): void
    {
        if (empty($hooks['register']) && empty($hooks['unregister'])) {
            throw YamlFileException::invalidHooksEmptyValue();
        }

        if (!empty($hooks['register']) && !is_array($hooks['register'])) {
            throw YamlFileException::invalidHooksValue('register');
        }

        if (!empty($hooks['register'])) {
            foreach ($hooks['register'] as $name => $hook) {
                $this->hookValidator->validate($hook, $name);
            }
        }

        if (!empty($hooks['unregister']) && !is_array($hooks['unregister'])) {
            throw YamlFileException::invalidHooksValue('unregister');
        }

        if (!empty($hooks['unregister'])) {
            foreach ($hooks['unregister'] as $name => $hook) {
                $this->hookValidator->validate($hook, $name);
            }
        }
    }
}
