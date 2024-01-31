<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Comparator;

interface PrestashopVersionComparatorInterface
{
    public function compare(string $version, string $operator): bool;

    public function setPrestashopVersion($version): void;
}
