<?php

namespace Bauhaus\DbAsserture\Sql;

class Table
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
