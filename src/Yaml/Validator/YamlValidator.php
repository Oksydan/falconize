<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\Validator;

use Oksydan\Falconize\Exception\YamlFileException;
use Oksydan\Falconize\Yaml\Validator\Database\DatabaseValidator;
use Oksydan\Falconize\Yaml\Validator\Hooks\HooksValidator;

final class YamlValidator implements YamlValidatorInterface
{
    private DatabaseValidator $databaseValidator;

    private HooksValidator $hooksValidator;

    public function __construct(
        DatabaseValidator $databaseValidator,
        HooksValidator $hooksValidator
    ) {
        $this->databaseValidator = $databaseValidator;
        $this->hooksValidator = $hooksValidator;
    }

    public function validate(?array $configuration): void
    {
        if (!is_array($configuration) || empty($configuration)) {
            throw new YamlFileException('Invalid configuration file, your file is empty');
        }

        if (
            (empty($configuration['database_tables']) || !is_array($configuration['database_tables'])) &&
            (empty($configuration['hooks']) || !is_array($configuration['hooks']))
        ) {
            throw new YamlFileException("Invalid configuration file structure. Your configuration file must contains at least 'database_tables' or 'hooks'");
        }

        if (!empty($configuration['database_tables'])) {
            $this->databaseValidator->validate($configuration['database_tables']);
        }

        if (!empty($configuration['hooks'])) {
            $this->hooksValidator->validate($configuration['hooks']);
        }
    }
}
