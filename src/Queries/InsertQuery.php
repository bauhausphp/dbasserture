<?php

namespace Bauhaus\DbAsserture\Queries;

class InsertQuery extends AbstractQuery
{
    public function __toString(): string
    {
        return "INSERT INTO {$this->table()} ({$this->columns()}) VALUES ({$this->params()})";
    }

    private function columns(): string
    {
        return implode(',', $this->register()->columns());
    }

    private function params(): string
    {
        return implode(',', $this->register()->queryParams());
    }
}
