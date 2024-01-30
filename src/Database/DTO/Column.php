<?php

declare(strict_types=1);

namespace Oksydan\Falconize\Database\DTO;

class Column implements DatabaseObjectInterface
{
    private string $name;

    private string $type;

    private ?int $length = null;

    private ?int $precision = null;

    private ?int $scale = null;

    private bool $unsigned = false;

    private bool $fixed = false;

    private bool $notnull = false;

    /**
     * @var mixed|null
     */
    private $default = null;

    private bool $autoincrement = false;

    public function __construct(
        string $name,
        string $type
    ) {
        $this->name = $name;
        $this->type = $type;
    }

    public function setLength(?int $length): void
    {
        $this->length = $length;
    }

    public function setPrecision(?int $precision): void
    {
        $this->precision = $precision;
    }

    public function setScale(?int $scale): void
    {
        $this->scale = $scale;
    }

    public function setUnsigned(bool $unsigned): void
    {
        $this->unsigned = $unsigned;
    }

    public function setFixed(bool $fixed): void
    {
        $this->fixed = $fixed;
    }

    public function setNotnull(bool $notnull): void
    {
        $this->notnull = $notnull;
    }

    public function setDefault($default): void
    {
        $this->default = $default;
    }

    public function setAutoincrement(bool $autoincrement): void
    {
        $this->autoincrement = $autoincrement;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOptions(): array
    {
        $options = [
            'length' => $this->length,
            'precision' => $this->precision,
            'scale' => $this->scale,
            'unsigned' => $this->unsigned,
            'fixed' => $this->fixed,
            'notnull' => $this->notnull,
            'default' => $this->default,
            'autoincrement' => $this->autoincrement,
        ];

        return array_filter($options, function ($value) {
            return $value !== null;
        });
    }
}
