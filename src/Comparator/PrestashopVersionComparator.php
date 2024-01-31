<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Comparator;

final class PrestashopVersionComparator implements PrestashopVersionComparatorInterface
{
    private ?string $prestashopVersion;


    public function compare(string $version, string $operator): bool
    {
        return version_compare($this->prestashopVersion, $version, $operator);
    }

    public function setPrestashopVersion($version): void
    {
        $this->prestashopVersion = $version;
    }
}
