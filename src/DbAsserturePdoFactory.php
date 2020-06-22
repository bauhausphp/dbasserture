<?php

namespace Bauhaus\DbAsserture;

use PDO;

class DbAsserturePdoFactory
{
    public function create(string $dsn, ?string $user, ?string $password): Pdo
    {
        return new PDO($dsn, $user, $password);
    }
}
