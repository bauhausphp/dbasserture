<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use PDO;

class DbAssertureFactory
{
    public static function create(PDO $pdo): DbAsserture
    {
        $database = new DbConnection($pdo);

        return new DbAsserture($database);
    }
}
