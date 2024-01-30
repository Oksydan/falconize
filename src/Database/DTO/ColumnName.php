<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\DTO;

class ColumnName implements DatabaseObjectInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
