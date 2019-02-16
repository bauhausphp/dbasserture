<?php

namespace Bauhaus\DbAsserture\Queries;

class SelectQuery extends AbstractQuery
{
    public function __toString(): string
    {
        return "SELECT * FROM {$this->table()} WHERE {$this->wheres()}";
    }

    private function wheres(): string
    {
        $columns = $this->register()->columns();
        $queryParams = $this->register()->queryParams();

        $wheres = [];
        foreach ($columns as $i => $column) {
            $wheres[] = "$column = {$queryParams[$i]}";
        }

        return implode(' AND ', $wheres);
    }
}
