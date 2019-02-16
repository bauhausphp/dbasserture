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
        $this->execute($query);
    }

    public function query(Query $query): array
    {
        $statement = $this->execute($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function execute(Query $query): PDOStatement
    {
        $statement = $this->prepare($query);
        $status = $statement->execute($query->binds());

        if (false === $status) {
            throw new DatabaseExecException($statement);
        }

        return $statement;
    }

    private function prepare(Query $query): PDOStatement
    {
        $statement = $this->pdo->prepare((string) $query);

        if (false === $statement) {
            throw new DatabasePrepareException($query);
        }

        return $statement;
    }
}
