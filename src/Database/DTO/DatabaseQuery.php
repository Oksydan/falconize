<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\DTO;

final class DatabaseQuery
{
    private string $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
