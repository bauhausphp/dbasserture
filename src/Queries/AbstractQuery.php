<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Query;

abstract class AbstractQuery implements Query
{
    /** @var string */
    private $table;

    /** @var string[] */
    private $register;

    public function __construct(string $table, array $register)
    {
        $this->table = $table;
        $this->register = $register;
    }

    public function binds(): array
    {
        return $this->register;
    }

    protected function table(): string
    {
        return $this->table;
    }

    protected function register(): array
    {
        return $this->register;
    }
}
