<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Helper;

final class TableNameFormatter implements TableNameFormatterInterface
{
    private ?string $prefix;

    public function getFullTableName(string $tableName): string
    {
        return $this->prefix . $tableName;
    }

    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }
}
