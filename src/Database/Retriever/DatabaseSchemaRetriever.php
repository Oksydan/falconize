<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Retriever;

use Doctrine\DBAL\Schema\Schema;
use Oksydan\Falconize\Connection\ConnectionManager;
use Oksydan\Falconize\Database\DTO\Table;
use Oksydan\Falconize\Helper\TableNameFormatter;

final class DatabaseSchemaRetriever implements DatabaseSchemaRetrieverInterface
{
    private ConnectionManager $connectionManager;

    private TableNameFormatter $tableNameFormatter;

    public function __construct(
        ConnectionManager $connectionManager,
        TableNameFormatter $tableNameFormatter
    ) {
        $this->connectionManager = $connectionManager;
        $this->tableNameFormatter = $tableNameFormatter;
    }

    public function getTableSchema(Table $table): Schema
    {
        $connection = $this->connectionManager->getConnection();
        $fullTableName = $this->tableNameFormatter->getFullTableName($table->getName());

        if ($connection->getSchemaManager()->tablesExist([$fullTableName])) {
            return new Schema([$connection->getSchemaManager()->listTableDetails($fullTableName)]);
        }

        return new Schema();
    }
}
