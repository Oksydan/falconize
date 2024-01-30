<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\DTO;

class Hook implements HookInterface
{
    private string $name;
    private ?string $version;
    private ?string $versionCompare;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    public function setVersionCompare(?string $versionCompare): void
    {
        $this->versionCompare = $versionCompare;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function getVersionCompare(): ?string
    {
        return $this->versionCompare;
    }
}
