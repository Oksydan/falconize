<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Connection;

use Doctrine\DBAL\Driver\Connection;

class ConnectionManager implements ConnectionManagerInterface
{
    private Connection $connection;

    public function setConnection(Connection $connection): void
    {
        $this->connection = $connection;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
}
