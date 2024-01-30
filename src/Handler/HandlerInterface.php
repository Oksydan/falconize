<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Handler;

use Oksydan\Falconize\Yaml\DTO\ParsedResult;

interface HandlerInterface
{
    public function handle(ParsedResult $config): void;
}
