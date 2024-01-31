# Falconize

Falconize is simple yet powerful tool that helps you to improve you development experience during PrestaShop modules development.

## Installation

```bash
  composer require oksydan/falconize
```

## Usage


## Configuration yaml file structure

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
