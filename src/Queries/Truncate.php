<?php

namespace Bauhaus\DbAsserture\Queries;

final class Truncate extends AbstractQuery
{
    public function __construct(string $table)
    {
        parent::__construct($table);
    }
}
