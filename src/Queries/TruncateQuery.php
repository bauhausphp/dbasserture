<?php

namespace Bauhaus\DbAsserture\Queries;

class TruncateQuery extends AbstractQuery
{
    public function __construct(string $table)
    {
        parent::__construct($table, []);
    }

    public function __toString(): string
    {
        return "TRUNCATE {$this->table()} CASCADE";
    }
}
