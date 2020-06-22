<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Sql\Register;

final class Select extends AbstractQuery
{
    public function __construct(string $table, Register $register)
    {
        parent::__construct($table, $register);
    }
}
