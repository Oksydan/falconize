<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Retriever;

use Doctrine\DBAL\Schema\Schema;
use Oksydan\Falconize\Database\DTO\Table;

interface DatabaseSchemaRetrieverInterface
{
    public function getTableSchema(Table $table): Schema;
}
