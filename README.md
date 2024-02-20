# Falconize

Falconize is simple yet powerful tool that helps you to improve you development experience during PrestaShop modules development.

## Installation

```bash
  composer require oksydan/falconize
```

## Usage

### Step 1 - Create FalconizeConfiguration

First you need to create FalconizeConfiguration class that implements FalconizeConfigurationInterface. This class will be used to configure Falconize.
Example FalconizeConfiguration class:

```php
<?php

namespace MyModule\NamespaceName;

use Doctrine\DBAL\Connection;
use Oksydan\Falconize\FalconizeConfigurationInterface;
use Oksydan\Falconize\PrestaShop\Module\PrestaShopModuleInterface;

final class FalconizeConfiguration implements FalconizeConfigurationInterface
{
    protected PrestaShopModuleInterface $module;

    protected Connection $connection;

    protected string $databasePrefix;

    protected string $prestashopVersion;

    public function __construct(
        PrestaShopModuleInterface $module,
        Connection $connection,
        string $databasePrefix,
        string $prestashopVersion
    ) {
        $this->module = $module;
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
        $this->prestashopVersion = $prestashopVersion;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getModule(): PrestaShopModuleInterface
    {
        return $this->module;
    }

    public function getConfigurationFile(): \SplFileInfo
    {
        // /../../config/configuration.yml is just an example path to configuration file
        return new \SplFileInfo(__DIR__ . '/../../config/configuration.yml');
    }

    public function getDatabasePrefix(): string
    {
        return $this->databasePrefix;
    }

    public function getPrestashopVersion(): string
    {
        return $this->prestashopVersion;
    }
}
```

### Step 2 - Create configuration file

Then create have to create configration file. Configuration file is a yaml file that contains information about database tables and hooks that you want to register/unregister.
Good practice is to place you configuration file inside `/modules/my_module/config` directory.
Example configuration file:

```yaml

database_tables:
  my_table_name:
    columns: 
      - name: id_my_table_name 
        type: integer
        length: 11 
        notnull: true 
        autoincrement: true
      - name: active
        type: boolean
        notnull: true
        default: 0
    primary:
      - id_my_table_name
    indexes:
      - name: my_table_name_active_index
        columns:
          - active

  my_table_name_lang:
    columns:
      - name: id_my_table_name
        type: integer
        length: 11
        notnull: true
      - name: id_lang
        type: integer
        length: 11
        notnull: true
      - name: name
        type: string
        length: 255
        notnull: true
    primary:
      - id_my_table_name
      - id_lang
  constraint_keys:
    - name: my_table_name_lang_constraint_lang
      foreign_table: lang
      update: NO ACTION
      delete: CASCADE
      local_columns:
        - id_lang
      foreign_columns:
        - id_lang

hooks:
  register:
    - name: displayHome
    - name: displayModernHook
      version: '8.0.0'
      compare_operator: '>='
    - name: displayLegacyHook
      version: '8.0.0'
      compare_operator: '<'
  unregister:
    - name: displayMyOldHook
```

### Step 3 - Create Falconize instance

Then you need to create `Falconize` instance passing `FalconizeConfiguration` instance to constructor.
Your main module class have to implement `Oksydan\Falconize\PrestaShop\Module\PrestaShopModuleInterface`

```php
<?php

use Oksydan\Falconize\Falconize;
use MyModule\NamespaceName\FalconizeConfiguration;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use Oksydan\Falconize\PrestaShop\Module\PrestaShopModuleInterface;

class MyModule extends Module implements PrestaShopModuleInterface
{
    protected Falconize $falconize;
    
    public function __construct()
    {
        ...
    }

    private function getFalconize()
    {
        if (!isset($this->falconize)) {
            $falconizeConfiguration = new FalconizeConfiguration(
                $this,
                SymfonyContainer::getInstance()->get('doctrine.dbal.default_connection'),
                _DB_PREFIX_,
                _PS_VERSION_
            );
            $this->falconize = new Falconize($falconizeConfiguration);
        }

        return $this->falconize;
    }
}
```

### Step 4 - Use Falconize

When step 3 is done you are able to use Falconize to handle your installation and uninstallation process.
Falconize will automatically register/unregister hooks and create/delete database tables.
In case of an installation/uninstallation error, Falconize will throw an exception providing information about error.

```php 
<?php

...

class MyModule extends Module implements PrestaShopModuleInterface
{
    ...
    
    public function install()
    {
        return parent::install() &&
               $this->getFalconize()->install();
    }

    public function uninstall()
    {
        return parent::uninstall() &&
               $this->getFalconize()->uninstall();
    }
}
```

## Usage during upgrade process

When you would like to upgrade your module you are able to use Falconize to handle your upgrade process.
Falconize will automatically register/unregister hooks and upgrade your database schema based on your updated configuration file.
If you change column type, add new column or remove column, add index etc. in your configuration file, Falconize will automatically upgrade your database schema on `Falconize::install()` call.

```php
<?php

function upgrade_module_1_1_0($module) // 1.1.0 is example version
{
    return $module->getFalconize()->install();
}
```

## Configuration yaml file

Configuration yaml file contains two main sections: `database_tables` and `hooks`.

### Database tables: `database_tables` (`array`)

`database_tables` section contains information about database tables that you want to create.
Schema is based on Doctrine DBAL schema.

#### Table name (`string`)

Table name is a key of `database_tables` section. It has to be unique. It only accepts alphanumeric characters and underscore.

Example:
```yaml
database_tables:
  my_table_name:
    ...
```

> [!IMPORTANT]  
> Order of tables is important. It's the same as order of execution.

#### Columns: `columns` (`array`)

Columns section contains information about table columns. It is an array of columns. Each column has to have `name` and `type` keys. Other keys are optional.

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: id_my_table_name
        ...
      - name: active
        ...
```

##### Column name: `name` (`string`)

Column name is a key of column section. It has to be unique. It only accepts alphanumeric characters and underscore.

Example:

```yaml

database_tables:
  my_table_name:
    columns:
      - name: id_my_table_name
        ...
```

##### Column type: `type` (`string`)

Column type is a key of column section. It has to be valid database column type. You can find all available types [here](https://www.doctrine-project.org/projects/doctrine-dbal/en/2.13/reference/types.html#types).

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: id_my_table_name
        type: integer
        ...
```

##### Column length `length` (`integer`) - optional

Column length is a key of column section. It has to be valid column length.

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: id_my_table_name
        ...
        length: 11
        ...
```

##### Column notnull: `notnull` (`boolean`) - optional

Column notnull is a key of column section. It has to be boolean.

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: id_my_table_name
        ...
        notnull: true
        ...
```

##### Column autoincrement: `autoincrement` (`boolean`) - optional

Column autoincrement is a key of column section. It has to be boolean.

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: id_my_table_name
        ...
        autoincrement: true
        ...
```

##### Column default: `default` (`mixed`) - optional

Column default is a key of column section. It has to be valid column default value.

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: active
        ...
        default: 0
        ...
```

#### Primary: `primary` (`array`) - optional

Primary section contains information about primary key. It is an array of column names.

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: id_my_table_name
        ...
    primary:
      - id_my_table_name
```

### Indexes: `indexes` (`array`) - optional

Indexes section contains information about indexes. It is an array of indexes. Each index has to have `name` and `columns` keys.

#### Index name: `name` (`string`)

Index name is a key of index section. It has to be unique. It only accepts alphanumeric characters and underscore.

#### Index columns: `columns` (`array`)

Index columns is a key of index section. It has to be an array of column names.

Example:

```yaml
database_tables:
  my_table_name:
    columns:
      - name: active
        ...
    indexes:
      - name: my_table_name_active_index
        columns:
          - active
```

### Constraint keys: `constraint_keys` (`array`) - optional

Constraint keys section contains information about constraint keys. It is an array of constraint keys. Each constraint key has to have `name`, `foreign_table`, `update`, `delete`, `local_columns` and `foreign_columns` keys.

#### Constraint key name: `name` (`string`)

Constraint key name is a key of constraint key section. It has to be unique. It only accepts alphanumeric characters and underscore.

#### Constraint key foreign table: `foreign_table` (`string`)

Constraint key foreign table is a key of constraint key section. It has to be valid table name.

#### Constraint key update: `update` (`string`)

Constraint key update is a key of constraint key section. It has to be valid constraint key update value. You can find all available values `'NO ACTION'`, `'CASCADE'`, `'SET NULL'`, `'RESTRICT'`, `'SET DEFAULT'`.

#### Constraint key delete: `delete` (`string`)

Constraint key delete is a key of constraint key section. It has to be valid constraint key delete value. You can find all available values `'NO ACTION'`, `'CASCADE'`, `'SET NULL'`, `'RESTRICT'`, `'SET DEFAULT'`.

#### Constraint key local columns: `local_columns` (`array`)

Constraint key local columns is a key of constraint key section. It has to be an array of column names.

#### Constraint key foreign columns: `foreign_columns` (`array`)

Constraint key foreign columns is a key of constraint key section. It has to be an array of column names.

Example:

```yaml
database_tables:
  my_table_name_lang:
    columns:
      - name: id_lang
        ...
    constraint_keys:
      - name: my_table_name_lang_constraint_lang
        foreign_table: lang
        update: NO ACTION
        delete: CASCADE
        local_columns:
          - id_lang
        foreign_columns:
          - id_lang
```

### Hooks: `hooks` (`array`)

Hooks section contains information about hooks that you want to register/unregister.

#### Register: `register` (`array`)

Register section contains information about hooks that you want to register. It is an array of hooks.

#### Unregister: `unregister` (`array`)

Unregister section contains information about hooks that you want to unregister. It is an array of hooks.

#### Hook name: `name` (`string`)

Hook name is a key of `register`/`unregister` section. It has to be valid hook name.

#### Hook version `version` (`string`) - optional

Hook version is a key of `register`/`unregister` section. It's PrestaShop version from which hook should be registered/unregistered based on compare operator.

#### Hook compare operator `compare_operator` (`string`) - optional

Hook compare operator is a key of `register`/`unregister` section. It has to be valid hook compare operator. You can find all available values `'<'`, `'>'`, `'='`, `'<='`, `'>='`.

Example:

```yaml
hooks:
  register:
    - name: displayHome
    - name: displayModernHook
      version: '8.0.0'
      compare_operator: '>='
    - name: displayLegacyHook
      version: '8.0.0'
      compare_operator: '<'
  unregister:
    - name: displayMyOldHook
```

### Splitting configuration file

You can split your configuration file into multiple files. It might be useful when your .yml file is getting bigger and bigger.

You can create multiple configuration files and then import them into main configuration file.

Example:

File: `my_table_name.yml`
```yaml
database_tables:
  my_table_name:
    columns: 
      - name: id_my_table_name 
        type: integer
        length: 11 
        notnull: true 
        autoincrement: true
      - name: active
        type: boolean
        notnull: true
        default: 0
    primary:
      - id_my_table_name
    indexes:
      - name: my_table_name_active_index
        columns:
          - active
```

File: `my_table_name_lang.yml`
```yaml
my_table_name_lang:
  columns:
    - name: id_my_table_name
      type: integer
      length: 11
      notnull: true
    - name: id_lang
      type: integer
      length: 11
      notnull: true
    - name: name
      type: string
      length: 255
      notnull: true
  primary:
    - id_my_table_name
    - id_lang
constraint_keys:
  - name: my_table_name_lang_constraint_lang
    foreign_table: lang
    update: NO ACTION
    delete: CASCADE
    local_columns:
      - id_lang
    foreign_columns:
      - id_lang
```

File: `hooks.yml`
```yaml
hooks:
  register:
    - name: displayHome
    - name: displayModernHook
      version: '8.0.0'
      compare_operator: '>='
    - name: displayLegacyHook
      version: '8.0.0'
      compare_operator: '<'
  unregister:
    - name: displayMyOldHook
```

Main configuration file:
```yaml
imports:
  - { resource: 'my_table_name.yml' }
  - { resource: 'my_table_name_lang.yml' }
  - { resource: 'hooks.yml' }
```

> [!IMPORTANT]  
> Order of imports is important. Configuration files are merged in the same order as they are imported.

