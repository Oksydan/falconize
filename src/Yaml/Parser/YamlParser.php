<?php

namespace Oksydan\Falconize\Yaml\Parser;

use Oksydan\Falconize\Exception\YamlFileException;
use Oksydan\Falconize\Mapper\Database\DatabaseMapperInterface;
use Oksydan\Falconize\Mapper\Hook\HooksMapper;
use Oksydan\Falconize\Mapper\Hook\HooksMapperInterface;
use Oksydan\Falconize\Yaml\DTO\ParsedResult;
use Oksydan\Falconize\Yaml\Validator\YamlValidatorInterface;
use Symfony\Component\Yaml\Yaml;

final class YamlParser implements YamlParserInterface
{
    private YamlValidatorInterface $validator;

    private DatabaseMapperInterface $databaseMapper;

    private HooksMapperInterface $hooksMapper;

    public function __construct(
        YamlValidatorInterface $validator,
        DatabaseMapperInterface $databaseMapper,
        HooksMapperInterface $hooksMapper
    ) {
        $this->validator = $validator;
        $this->databaseMapper = $databaseMapper;
        $this->hooksMapper = $hooksMapper;
    }

    public function parse(\SplFileInfo $file): ParsedResult
    {
        $result = new ParsedResult();
        $configuration = $this->parseAndMergeYamlFiles($file);

        $this->validator->validate($configuration);

        if (!empty($configuration['database_tables'])) {
            $result->setDatabaseCollection($this->databaseMapper->mapArrayToDatabaseCollection($configuration['database_tables']));
        }

        if (!empty($configuration['hooks']['register'])) {
            $result->setHookToRegister($this->hooksMapper->mapArrayToHookCollection($configuration['hooks']['register']));
        }

        if (!empty($configuration['hooks']['unregister'])) {
            $result->setHookToUnregister($this->hooksMapper->mapArrayToHookCollection($configuration['hooks']['unregister']));
        }

        return $result;
    }

    private function parseAndMergeYamlFiles(\SplFileInfo $file): array
    {
        try {
            $config = Yaml::parseFile($file->getPathname());
        } catch (\Exception $exception) {
            throw new YamlFileException($exception->getMessage(), $exception->getCode(), $exception);
        }

        if (isset($config['imports']) && is_array($config['imports'])) {
            $importedFiles = array_column($config['imports'], 'resource');
            $importedConfig = [];

            foreach ($importedFiles as $importedFile) {
                $importedFile = new \SplFileInfo($file->getPath() . '/' . $importedFile);
                $importedConfig = array_merge_recursive($importedConfig, $this->parseAndMergeYamlFiles($importedFile));
            }

            $config = array_merge_recursive($importedConfig, $config);
            unset($config['imports']);
        }

        return $config;
    }
}
