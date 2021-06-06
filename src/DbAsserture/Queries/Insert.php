<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Sql\Register;

final class Insert extends AbstractQuery
{
    private Register $newRegister;

    public function __construct(string $table, Register $newRegister)
    {
        parent::__construct($table);

        $this->newRegister = $newRegister;
    }

    public function columns(): array
    {
        return $this->newRegister->columns();
    }

    public function params(): array
    {
        return $this->newRegister->queryParams();
    }

    public function binds(): array
    {
        return $this->newRegister->queryBinds();
    }
}
