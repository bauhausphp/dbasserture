<?php

namespace Bauhaus\DbAsserture;

use PDO;

class Database
{
    /** @var PDO */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function exec(Query $query): void
    {
        $sth = $this->pdo->prepare((string) $query);

        $sth->execute($query->binds());
    }
}
