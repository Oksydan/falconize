<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Executor;

use Oksydan\Falconize\Database\Collection\DatabaseQueryCollection;

interface DatabaseQueryExecutorInterface
{
    public function execute(DatabaseQueryCollection $queryCollection): void;
}
