<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\Builder;

use Doctrine\DBAL\Schema\Schema;
use Oksydan\Falconize\Database\DTO\Table;

interface SchemaBuilderInterface
{
    public function build(Table $table): Schema;
}
