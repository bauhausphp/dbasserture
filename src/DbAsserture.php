<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\Truncate;
use Bauhaus\DbAsserture\Sql\Register;

class DbAsserture
{
    private DbConnection $dbConnection;

    public function __construct(DbConnection $database)
    {
        $this->dbConnection = $database;
    }

    public function insertOne(string $table, array $register): void
    {
        $insert = new Insert($table, new Register($register));

        $this->dbConnection->run($insert);
    }

    public function insertMany(string $table, array $registers): void
    {
        foreach ($registers as $register) {
            $this->insertOne($table, $register);
        }
    }

    public function cleanTable(string $table): void
    {
        $this->dbConnection->run(new Truncate($table));
    }

    public function selectMany(string $table, array $filters): array
    {
        return $this->dbConnection->query(new Select($table, new Register($filters)));
    }

    public function selectOne(string $table, array $filters): array
    {
        $registers = $this->selectMany($table, $filters);

        if (count($registers) !== 1) {
            throw new DbAssertureMoreThanOneRegisterFoundException();
        }

        return $registers[0];
    }

    public function assertOneIsRegistered(string $table, array $register): bool
    {
        $select = new Select($table, new Register($register));
        $registers = $this->dbConnection->query($select);

        if (count($registers) !== 1) {
            throw new DbAssertureOneIsRegisteredFailedException($select, $registers);
        }

        return true;
    }
}
