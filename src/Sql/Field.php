<?php

namespace Bauhaus\DbAsserture\Sql;

class Field
{
    /** @var string */
    private $name;

    /** @var string */
    private $value;

    /** @var bool */
    private $bindable;

    private function __construct(string $name, string $value, bool $bindable)
    {
        $this->name = $name;
        $this->value = $value;
        $this->bindable = $bindable;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function escapedName(): string
    {
        return new EscapedToken($this->name());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function queryParam(): string
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
        $isBindable = !$value instanceof SqlExpression;

        return new self($name, $value, $isBindable);
    }
}
