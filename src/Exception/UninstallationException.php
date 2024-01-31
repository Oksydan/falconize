<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Exception;

class UninstallationException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
