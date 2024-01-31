<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\DTO;

class Hook implements HookInterface
{
    private string $name;
    private ?string $version = null;
    private ?string $compareOperator = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    public function setCompareOperator(?string $compareOperator): void
    {
        $this->compareOperator = $compareOperator;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function getCompareOperator(): ?string
    {
        return $this->compareOperator;
    }
}
