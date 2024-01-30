<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Handler;

use Oksydan\Falconize\Connection\ConnectionManager;
use Oksydan\Falconize\Helper\TableNameFormatterInterface;
use Oksydan\Falconize\Yaml\DTO\ParsedResult;

class UninstallationHandler implements HandlerInterface
{
    private ConnectionManager $connectionManager;

    private TableNameFormatterInterface $tableNameFormatter;

    public function __construct(
        ConnectionManager $connectionManager,
        TableNameFormatterInterface $tableNameFormatter
    ) {
        $this->connectionManager = $connectionManager;
        $this->tableNameFormatter = $tableNameFormatter;
    }

    public function handle(ParsedResult $config): void
    {
        // TODO: Implement handle() method.
    }
}
