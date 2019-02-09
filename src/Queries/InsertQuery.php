<?php

namespace Bauhaus\DbAsserture\Queries;

class InsertQuery extends AbstractQuery
{
    public function __toString(): string
    {
        $table = $this->table();
        $columns = $this->columns();
        $valuesToBind = $this->valuesToBind();

        return "INSERT INTO `{$table}` ($columns) VALUES ($valuesToBind)";
    }

    private function columns(): string
    {
        return '`'.implode('`,`', $this->fields()).'`';
    }

    private function valuesToBind(): string
    {
        return ':'.implode(',:', $this->fields());
    }

    /**
     * @return string[]
     */
    private function fields(): array
    {
        return array_keys($this->register());
    }
}
