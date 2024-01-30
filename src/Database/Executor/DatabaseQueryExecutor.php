<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Executor;

use Oksydan\Falconize\Connection\ConnectionManager;
use Oksydan\Falconize\Database\Collection\DatabaseQueryCollection;
use Oksydan\Falconize\Database\DTO\DatabaseQuery;

final class DatabaseQueryExecutor implements DatabaseQueryExecutorInterface
{
    private ConnectionManager $connectionManager;

    public function __construct(
        ConnectionManager $connectionManager
    ) {
        $this->connectionManager = $connectionManager;
    }

    /**
     * @param DatabaseQueryCollection $queryCollection
     * @return void
     * @throws \Exception
     */
    public function execute(DatabaseQueryCollection $queryCollection): void
    {
        $connection = $this->connectionManager->getConnection();

        /* @var DatabaseQuery $query */
        foreach ($queryCollection as $query) {
            $connection->executeQuery($query->getQuery());
        }
    }
}
