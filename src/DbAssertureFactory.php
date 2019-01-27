<?php

namespace Bauhaus\DbAsserture;

use PDO;

class DbAssertureFactory
{
    public static function create(PDO $pdo): DbAsserture
    {
        $database = new Database($pdo);

        return new DbAsserture($database);
    }
}
