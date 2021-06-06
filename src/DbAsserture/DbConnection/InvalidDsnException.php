<?php

namespace Bauhaus\DbAsserture\DbConnection;

use InvalidArgumentException;
use Throwable;

class InvalidDsnException extends InvalidArgumentException
{
    public function __construct(string $dsn, Throwable $previous)
    {
        parent::__construct("Invalid DSN provided: $dsn", 0, $previous);
    }
}
