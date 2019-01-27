<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Query;

class TruncateQuery implements Query
{
    /** @var string */
    private $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function __toString(): string
    {
        return "TRUNCATE `{$this->table}`";
    }

    public function binds(): array
    {
        return [];
    }
}
