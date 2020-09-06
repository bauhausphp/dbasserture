<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class DbAssertureOneIsRegisteredFailedException extends RuntimeException
{
    public function __construct(string $table, array $filter, array $expected, array $actual)
    {
        $message = '';

        parent::__construct($message);
    }
}
