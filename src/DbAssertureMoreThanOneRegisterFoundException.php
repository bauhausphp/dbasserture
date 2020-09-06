<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class DbAssertureMoreThanOneRegisterFoundException extends RuntimeException
{
    public function __construct(string $table, array $filters, array $registers)
    {
    }
}
