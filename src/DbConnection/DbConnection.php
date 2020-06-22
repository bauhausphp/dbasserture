<?php

namespace Bauhaus\DbAsserture\DbConnection;

use Bauhaus\DbAsserture\Queries\Query;
use Bauhaus\DbAsserture\QueryBuilders\QueryBuilder;
use Bauhaus\DbAsserture\Sql\Register;
use PDO;
use PDOStatement;

class DbConnection
{
    private PDO $pdo;
    private QueryBuilder $queryBuilder;

    public function __construct(PDO $pdo, QueryBuilder $queryBuilder)
    {
        $this->pdo = $pdo;
        $this->queryBuilder = $queryBuilder;
    }

    public function run(Query $query): void
    {
        $this->execute($query);
    }

    public function query(Query $query): array
    {
        $statement = $this->execute($query);

        return $this->registersFromPdoStatement($statement);
    }

    private function execute(Query $query): PDOStatement
    {
        $statement = $this->prepare($query);
        $status = $statement->execute($query->binds());

        if (false === $status) {
            throw new DbExecException($statement);
        }

        return $statement;
    }

    private function prepare(Query $query): PDOStatement
    {
        $query = $this->queryBuilder->build($query);
        $statement = $this->pdo->prepare($query);

        if (false === $statement) {
            throw new DbPrepareException($query);
        }

        return $statement;
    }

    private function registersFromPdoStatement(PDOStatement $statement): array
    {
        $fetchedRows = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn(array $row) => new Register($row), $fetchedRows);
    }
}
