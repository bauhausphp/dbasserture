<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\Queries\Query;
use PDO;
use PDOStatement;

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
        $statement = $this->prepare($query);
        $this->execute($statement, $query);
    }

    public function query(Query $query): array
    {
        $statement = $this->prepare($query);
        $this->execute($statement, $query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function prepare(Query $query): PDOStatement
    {
        $statement = $this->pdo->prepare((string) $query);

        if (false === $statement) {
            throw new DatabasePrepareException($query);
        }

        return $statement;
    }

    private function execute(PDOStatement $statement, Query $query): void
    {
        $status = $statement->execute($query->binds());

        if (false === $status) {
            throw new DatabaseExecException($statement);
        }
    }
}
