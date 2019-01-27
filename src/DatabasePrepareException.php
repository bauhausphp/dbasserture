<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class DatabasePrepareException extends RuntimeException
{
    public function __construct(Query $query)
    {
        parent::__construct("Error to prepare query $query");
    }
}
