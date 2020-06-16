<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Sql\Register;
use Bauhaus\DbAsserture\Sql\Table;

abstract class AbstractQuery implements Query
{
    private Table $table;

    private Register $register;

    /**
     * @param string|int[] $register
     */
    public function __construct(string $table, array $register)
    {
        $this->table = new Table($table);
        $this->register = new Register($register);
    }

    /**
     * {@inheritdoc}
     */
    public function binds(): array
    {
        return $this->register->queryBinds();
    }

    protected function table(): Table
    {
        return $this->table;
    }

    protected function register(): Register
    {
        return $this->register;
    }
}
