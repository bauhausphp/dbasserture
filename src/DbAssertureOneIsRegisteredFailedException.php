<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class DbAssertureOneIsRegisteredFailedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Failed finding one registred in database');
    }
}
