<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Handler;

use Oksydan\Falconize\Connection\ConnectionManager;
use Oksydan\Falconize\Database\Builder\SchemaBuilder;
use Oksydan\Falconize\Database\Collection\DatabaseQueryCollection;
use Oksydan\Falconize\Database\Comparator\SchemaComparator;
use Oksydan\Falconize\Database\DTO\DatabaseQuery;
use Oksydan\Falconize\Database\DTO\Table;
use Oksydan\Falconize\Database\Retriever\DatabaseSchemaRetriever;
use Oksydan\Falconize\Database\Executor\DatabaseQueryExecutor;
use Oksydan\Falconize\Yaml\DTO\ParsedResult;

class InstallationHandler implements HandlerInterface
{
    private ConnectionManager $connectionManager;

    private DatabaseQueryExecutor $databaseQueryExecutor;

    private SchemaComparator $schemaComparator;

    private SchemaBuilder $schemaBuilder;

    private DatabaseSchemaRetriever $databaseSchemaRetriever;

    public function __construct(
        ConnectionManager $connectionManager,
        DatabaseQueryExecutor $databaseQueryExecutor,
        SchemaComparator $schemaComparator,
        SchemaBuilder $schemaBuilder,
        DatabaseSchemaRetriever $databaseSchemaRetriever
    ) {
        $this->connectionManager = $connectionManager;
        $this->databaseQueryExecutor = $databaseQueryExecutor;
        $this->schemaComparator = $schemaComparator;
        $this->schemaBuilder = $schemaBuilder;
        $this->databaseSchemaRetriever = $databaseSchemaRetriever;
    }

    public function handle(ParsedResult $config): void
    {
        $connection = $this->connectionManager->getConnection();
        $tables = $config->getDatabaseCollection();
        $queryCollection = new DatabaseQueryCollection();

        /** @var Table $table */
        foreach ($tables as $table) {
            $fromSchema = $this->databaseSchemaRetriever->getTableSchema($table);
            $toSchema = $this->schemaBuilder->build($table);
            $diff = $this->schemaComparator->compare($fromSchema, $toSchema);

            $queries = $diff->toSql($connection->getDatabasePlatform());

            foreach ($queries as $query) {
                $queryCollection->add(new DatabaseQuery($query));
            }
        }

        $this->databaseQueryExecutor->execute($queryCollection);
    }
}
