<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Service;

use Oksydan\Falconize\Comparator\PrestashopVersionComparator;
use Oksydan\Falconize\Connection\ConnectionManager;
use Oksydan\Falconize\FalconizeConfigurationInterface;
use Oksydan\Falconize\Helper\TableNameFormatter;
use Oksydan\Falconize\Module\ModuleManager;

final class PrepareConfiguration implements PrepareConfigurationInterface
{
    private ConnectionManager $connectionManager;

    private ModuleManager $moduleManager;

    private TableNameFormatter $tableNameFormatter;

    private PrestashopVersionComparator $prestashopVersionComparator;

    public function __construct(
        ConnectionManager $connectionManager,
        ModuleManager $moduleManager,
        TableNameFormatter $tableNameFormatter,
        PrestashopVersionComparator $prestashopVersionComparator
    ) {
        $this->connectionManager = $connectionManager;
        $this->moduleManager = $moduleManager;
        $this->tableNameFormatter = $tableNameFormatter;
        $this->prestashopVersionComparator = $prestashopVersionComparator;
    }

    public function prepare(FalconizeConfigurationInterface $configuration): void
    {
        $this->connectionManager->setConnection($configuration->getConnection());
        $this->moduleManager->setModule($configuration->getModule());
        $this->tableNameFormatter->setPrefix($configuration->getDatabasePrefix());
        $this->prestashopVersionComparator->setPrestashopVersion($configuration->getPrestashopVersion());
    }
}
