<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Sql\Register;

abstract class AbstractQuery implements Query
{
    private string $table;
    private ?Register $register;

    public function __construct(string $table, Register $register = null)
    {
        $this->table = $table;
        $this->register = $register;
    }

    public function table(): string
    {
        return $this->table;
    }

    public function columns(): array
    {
        return $this->hasRegister() ? $this->register->columns() : [];
    }

    public function params(): array
    {
        return $this->hasRegister() ? $this->register->queryParams() : [];
    }

    private function hasRegister(): bool
    {
        return null !== $this->register;
    }
}
