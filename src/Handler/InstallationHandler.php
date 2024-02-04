<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Handler;

use Oksydan\Falconize\Comparator\PrestashopVersionComparator;
use Oksydan\Falconize\Connection\ConnectionManager;
use Oksydan\Falconize\Database\Builder\SchemaBuilder;
use Oksydan\Falconize\Database\Collection\DatabaseQueryCollection;
use Oksydan\Falconize\Database\Comparator\SchemaComparator;
use Oksydan\Falconize\Database\DTO\DatabaseQuery;
use Oksydan\Falconize\Database\DTO\Table;
use Oksydan\Falconize\Database\Executor\DatabaseQueryExecutor;
use Oksydan\Falconize\Database\Retriever\DatabaseSchemaRetriever;
use Oksydan\Falconize\Exception\DatabaseQueryException;
use Oksydan\Falconize\Exception\HookRegisterException;
use Oksydan\Falconize\Exception\HookUnregisterException;
use Oksydan\Falconize\Hook\Collection\HookCollection;
use Oksydan\Falconize\Hook\DTO\Hook;
use Oksydan\Falconize\Hook\Executor\ModuleHookRegisterExecutor;
use Oksydan\Falconize\Hook\Executor\ModuleHookUnregisterExecutor;
use Oksydan\Falconize\Yaml\DTO\ParsedResult;

class InstallationHandler implements HandlerInterface
{
    private ConnectionManager $connectionManager;

    private DatabaseQueryExecutor $databaseQueryExecutor;

    private SchemaComparator $schemaComparator;

    private SchemaBuilder $schemaBuilder;

    private DatabaseSchemaRetriever $databaseSchemaRetriever;

    private PrestashopVersionComparator $prestashopVersionComparator;

    private ModuleHookRegisterExecutor $moduleHookRegisterExecutor;

    private ModuleHookUnregisterExecutor $moduleHookUnregisterExecutor;

    public function __construct(
        ConnectionManager $connectionManager,
        DatabaseQueryExecutor $databaseQueryExecutor,
        SchemaComparator $schemaComparator,
        SchemaBuilder $schemaBuilder,
        DatabaseSchemaRetriever $databaseSchemaRetriever,
        PrestashopVersionComparator $prestashopVersionComparator,
        ModuleHookRegisterExecutor $moduleHookRegisterExecutor,
        ModuleHookUnregisterExecutor $moduleHookUnregisterExecutor
    ) {
        $this->connectionManager = $connectionManager;
        $this->databaseQueryExecutor = $databaseQueryExecutor;
        $this->schemaComparator = $schemaComparator;
        $this->schemaBuilder = $schemaBuilder;
        $this->databaseSchemaRetriever = $databaseSchemaRetriever;
        $this->prestashopVersionComparator = $prestashopVersionComparator;
        $this->moduleHookRegisterExecutor = $moduleHookRegisterExecutor;
        $this->moduleHookUnregisterExecutor = $moduleHookUnregisterExecutor;
    }

    /**
     * @param ParsedResult $config
     * @return void
     * @throws DatabaseQueryException|HookUnregisterException|HookRegisterException
     */
    public function handle(ParsedResult $config): void
    {
        $this->installDatabase($config);
        $this->unregisterHooks($config);
        $this->registerHooks($config);
    }

    /**
     * @param ParsedResult $config
     * @return void
     * @throws DatabaseQueryException
     */
    private function installDatabase(ParsedResult $config)
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

    private function getFilteredHooks(HookCollection $hookCollection): HookCollection
    {
        $filteredCollection = new HookCollection();

        /** @var Hook $hook */
        foreach ($hookCollection as $hook) {
            if ($hook->getVersion() && $hook->getCompareOperator() &&
                $this->prestashopVersionComparator->compare($hook->getVersion(), $hook->getCompareOperator())) {
                $filteredCollection->add($hook);
            } else {
                $filteredCollection->add($hook);
            }
        }

        return $filteredCollection;
    }

    /**
     * @param ParsedResult $config
     * @return void
     * @throws HookUnregisterException
     */
    private function unregisterHooks(ParsedResult $config)
    {
        $hooks = $config->getHookToUnregister();

        if (!$hooks) {
            return;
        }

        $filteredCollection = $this->getFilteredHooks($hooks);

        $this->moduleHookUnregisterExecutor->execute($filteredCollection);
    }

    /**
     * @param ParsedResult $config
     * @return void
     * @throws HookRegisterException
     */
    private function registerHooks(ParsedResult $config)
    {
        $hooks = $config->getHookToRegister();

        if (!$hooks) {
            return;
        }

        $filteredCollection = $this->getFilteredHooks($hooks);

        $this->moduleHookRegisterExecutor->execute($filteredCollection);
    }
}
