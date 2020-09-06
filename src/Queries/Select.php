<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Sql\Register;

final class Select extends AbstractQuery
{
    private Register $filter;

    public function __construct(string $table, Register $filter)
    {
        parent::__construct($table);

        $this->filter = $filter;
    }

    public function filters(): array
    {
        $filters = [];
        foreach ($this->filter->columns() as $k => $column) {
            $filters[$column] = $this->filter->queryParams()[$k];
        }

        return $filters;
    }

    public function binds(): array
    {
        return $this->filter->queryBinds();
    }
}
