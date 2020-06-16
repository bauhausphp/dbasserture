<?php

namespace Bauhaus\DbAsserture\DbConnection;

use Bauhaus\DbAsserture\Queries\Query;
use Bauhaus\DbAsserture\Sql\Register;
use PDO;
use PDOStatement;

class DbConnection
{
    private PDO $pdo;

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

        return $this->createRegisters($statement);
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
        $statement = $this->pdo->prepare((string) $query);

        if (false === $statement) {
            throw new DbPrepareException($query);
        }

        return $statement;
    }

    /**
     * @return Register[]
     */
    private function createRegisters(PDOStatement $statement): array
    {
        $registers = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $register) {
            $registers[] = new Register($register);
        }

        return $registers;
    }
}
