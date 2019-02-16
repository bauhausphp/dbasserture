<?php

namespace Bauhaus\DbAsserture\Sql;

class Table extends EscapedToken
{
    public function __toString(): string
    {
        return $this->escaped();
    }
}
