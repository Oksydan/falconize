<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Hook\DTO;

interface HookInterface
{
    public function getName(): string;

    public function getVersion(): ?string;

    public function getCompareOperator(): ?string;
}
