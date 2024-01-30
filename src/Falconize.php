<?php

declare(strict_types=1);

namespace Oksydan\Falconize;

use Oksydan\Falconize\Connection\ConnectionManager;
use Oksydan\Falconize\Exception\YamlFileException;
use Oksydan\Falconize\Handler\InstallationHandler;
use Oksydan\Falconize\Handler\UninstallationHandler;
use Oksydan\Falconize\Helper\TableNameFormatter;
use Oksydan\Falconize\Module\ModuleManager;
use Oksydan\Falconize\Yaml\DTO\ParsedResult;
use Oksydan\Falconize\Yaml\Parser\YamlParser;

class Falconize implements FalconizeInterface
{
    protected Container $container;

    protected FalconizeConfigurationInterface $configuration;

    public function __construct(FalconizeConfigurationInterface $configuration)
    {
        $this->container = new Container();
        $this->configuration = $configuration;
    }

    private function setConnection(): void
    {
        /** @var ConnectionManager $connectionManager */
        $connectionManager = $this->container->get(ConnectionManager::class);
        $connectionManager->setConnection($this->configuration->getConnection());
    }

    private function setModule(): void
    {
        /** @var ModuleManager $moduleManager */
        $moduleManager = $this->container->get(ModuleManager::class);
        $moduleManager->setModule($this->configuration->getModule());
    }

    private function setDatabasePrefix(): void
    {
        /** @var TableNameFormatter $tableNameService */
        $tableNameService = $this->container->get(TableNameFormatter::class);
        $tableNameService->setPrefix($this->configuration->getDatabasePrefix());
    }

    private function prepare(): void
    {
        $this->setConnection();
        $this->setDatabasePrefix();
        $this->setModule();
    }

    /**
     * @return ParsedResult
     *
     * @throws YamlFileException
     */
    private function getParsedConfiguration(): ParsedResult
    {
        $configurationFile = $this->configuration->getConfigurationFile();
        /* @var YamlParser $parser */
        $parser = $this->container->get(YamlParser::class);

        return $parser->parse($configurationFile);
    }

    public function install(): bool
    {
        $this->prepare();

        $installationHandler = $this->container->get(InstallationHandler::class);

        $installationHandler->handle($this->getParsedConfiguration());

        return true;
    }

    public function update(): bool
    {
        return $this->install();
    }

    public function uninstall(): bool
    {
        $this->prepare();

        $uninstallationHandler = $this->container->get(UninstallationHandler::class);

        $uninstallationHandler->handle($this->getParsedConfiguration());

        return true;
    }
}
