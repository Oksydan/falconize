<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Helper;

interface TableNameFormatterInterface
{
    public function getFullTableName(string $tableName): string;

    public function setPrefix(string $prefix): void;
}
