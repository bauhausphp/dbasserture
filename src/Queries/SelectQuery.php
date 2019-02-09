<?php

namespace Bauhaus\DbAsserture\Queries;

class SelectQuery extends AbstractQuery
{
    public function __toString(): string
    {
        $table = $this->table();
        $wheres = $this->wheres();

        return "SELECT * FROM `$table` WHERE $wheres";
    }

    private function wheres(): string
    {
        $wheres = [];
        foreach ($this->fields() as $field) {
            $wheres[] = "$field = :$field";
        }

        return implode(' AND ', $wheres);
    }

    /**
     * @return string[]
     */
    private function fields(): array
    {
        return array_keys($this->register());
    }
}
