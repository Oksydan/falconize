<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Mapper\Hook;

use Oksydan\Falconize\Hook\Collection\HookCollection;

interface HooksMapperInterface
{
    public function mapArrayToHookCollection(array $array): HookCollection;
}
