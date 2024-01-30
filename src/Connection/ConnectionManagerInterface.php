<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Connection;

use Doctrine\DBAL\Driver\Connection;

interface ConnectionManagerInterface
{
    public function setConnection(Connection $connection): void;

    public function getConnection(): Connection;
}
