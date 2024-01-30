<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Yaml\DTO;

use Oksydan\Falconize\Database\Collection\DatabaseObjectsCollection;
use Oksydan\Falconize\Hook\Collection\HookCollection;

class ParsedResult
{
    private ?DatabaseObjectsCollection $databaseObjectsCollection = null;

    private ?HookCollection $hookToRegister = null;

    private ?HookCollection $hookToUnregister = null;

    public function setDatabaseCollection(DatabaseObjectsCollection $databaseObjectsCollection): void
    {
        $this->databaseObjectsCollection = $databaseObjectsCollection;
    }

    public function getDatabaseCollection(): ?DatabaseObjectsCollection
    {
        return $this->databaseObjectsCollection;
    }

    public function setHookToRegister(HookCollection $hookToRegister): void
    {
        $this->hookToRegister = $hookToRegister;
    }

    public function getHookToRegister(): ?HookCollection
    {
        return $this->hookToRegister;
    }

    public function setHookToUnregister(HookCollection $hookToUnregister): void
    {
        $this->hookToUnregister = $hookToUnregister;
    }

    public function getHookToUnregister(): ?HookCollection
    {
        return $this->hookToUnregister;
    }
}
