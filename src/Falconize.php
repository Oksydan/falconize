<?php

declare(strict_types=1);

namespace Oksydan\Falconize;

use Oksydan\Falconize\Exception\DatabaseQueryException;
use Oksydan\Falconize\Exception\HookRegisterException;
use Oksydan\Falconize\Exception\HookUnregisterException;
use Oksydan\Falconize\Exception\InstallationException;
use Oksydan\Falconize\Exception\UninstallationException;
use Oksydan\Falconize\Exception\YamlFileException;
use Oksydan\Falconize\Handler\InstallationHandler;
use Oksydan\Falconize\Handler\UninstallationHandler;
use Oksydan\Falconize\Service\PrepareConfiguration;
use Oksydan\Falconize\Yaml\DTO\ParsedResult;
use Oksydan\Falconize\Yaml\Parser\YamlParser;

class Falconize implements FalconizeInterface
{
    public const RETURN_EXCEPTION_ON_EXCEPTION = 0;

    public const RETURN_FALSE_ON_EXCEPTION = 1;

    protected Container $container;

    protected FalconizeConfigurationInterface $configuration;

    public function __construct(FalconizeConfigurationInterface $configuration)
    {
        $this->container = new Container();
        $this->configuration = $configuration;
    }

    private function prepare(): void
    {
        $this->container->get(PrepareConfiguration::class)->prepare($this->configuration);
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

    /**
     * @param int $onException
     * @return bool|void
     * @throws InstallationException
     */
    public function install(int $onException = self::RETURN_EXCEPTION_ON_EXCEPTION)
    {
        $this->prepare();

        try {
            $installationHandler = $this->container->get(InstallationHandler::class);

            $installationHandler->handle($this->getParsedConfiguration());
        } catch (YamlFileException|DatabaseQueryException|HookUnregisterException|HookRegisterException $e) {
            if ($onException === self::RETURN_EXCEPTION_ON_EXCEPTION) {
                throw new InstallationException($e->getMessage());
            } elseif ($onException === self::RETURN_FALSE_ON_EXCEPTION) {
                return false;
            }
        }
    }

    /**
     * @param int $onException
     * @return bool|void
     * @throws UninstallationException
     */
    public function uninstall(int $onException = self::RETURN_EXCEPTION_ON_EXCEPTION)
    {
        $this->prepare();

        try {
            $uninstallationHandler = $this->container->get(UninstallationHandler::class);

            $uninstallationHandler->handle($this->getParsedConfiguration());
        } catch (YamlFileException|DatabaseQueryException $e) {
            if ($onException === self::RETURN_EXCEPTION_ON_EXCEPTION) {
                throw new UninstallationException($e->getMessage());
            } elseif ($onException === self::RETURN_FALSE_ON_EXCEPTION) {
                return false;
            }
        }
    }
}
