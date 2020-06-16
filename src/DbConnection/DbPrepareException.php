<?php

namespace Bauhaus\DbAsserture\DbConnection;

use Bauhaus\DbAsserture\Queries\Query;
use RuntimeException;

class DbPrepareException extends RuntimeException
{
    public function __construct(Query $query)
    {
        parent::__construct("Error to prepare query $query");
    }
}
