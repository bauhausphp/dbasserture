<?php

namespace Bauhaus\DbAsserture\Sql;

class Field
{
    private string $name;
    private ?string $value;
    private bool $bindable;

    private function __construct(string $name, ?string $value, bool $bindable)
    {
        $this->name = $name;
        $this->value = $value;
        $this->bindable = $bindable;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function rawValue(): ?string
    {
        return $this->value;
    }

    public function value(): string
    {
        return is_null($this->value) ? 'NULL' : $this->value;
    }

    public function queryParam(): ?string
    {
        return $this->isBindable() ? ":{$this->name()}" : $this->value();
    }

    public function isBindable(): bool
    {
        return $this->bindable;
    }

    /**
     * @param string|SqlExpression $value
     */
    public static function create(string $name, $value): self
    {
        $notSqlExpression = !$value instanceof SqlExpression;
        $notNull = is_null($value) === false;
        $isBindable = $notSqlExpression && $notNull;

        return new self($name, $value, $isBindable);
    }
}
