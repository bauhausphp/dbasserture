<?php

namespace Bauhaus\DbAsserture\DbConnection;

use Bauhaus\DbAsserture\Queries\Query;
use Bauhaus\DbAsserture\QueryBuilders\QueryBuilder;
use Bauhaus\DbAsserture\Sql\Register;
use PDO;
use PDOException;
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

        try {
            $statement->execute($query->binds());
        } catch (PDOException $ex) {
            throw new DbExecException($ex);
        }

        return $statement;
    }

    private function prepare(Query $query): PDOStatement
    {
        $query = $this->queryBuilder->build($query);

        try {
            $statement = $this->pdo->prepare($query);
        } catch (PDOException) {
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
