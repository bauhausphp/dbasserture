<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\DeleteAll;
use Bauhaus\DbAsserture\Sql\Register;

class DbAsserture
{
    private const DEFAULT_ASSERT_FILTER_FIELD = 'id';
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
        $this->dbConnection->run(new DeleteAll($table));
    }

    public function selectMany(string $table, array $filters): array
    {
        $registers = $this->dbConnection->query(new Select($table, new Register($filters)));

        return array_map(fn(Register $register) => $register->asArray(), $registers);
    }

    public function selectOne(string $table, array $filters): array
    {
        $registers = $this->selectMany($table, $filters);

        if (count($registers) !== 1) {
            throw new DbAssertureMoreThanOneRegisterFoundException($table, $filters, $registers);
        }

        return $registers[0];
    }

    public function assertOneIsRegistered(string $table, array $expected, string $filterField = null): bool
    {
        $filterField = $filterField ?? self::DEFAULT_ASSERT_FILTER_FIELD;
        $filter = [$filterField => $expected[$filterField]];
        $actual = $this->selectOne($table, $filter);

        if ($expected == $actual) {
            return true;
        }

        throw new DbAssertureOneIsRegisteredFailedException($table, $filter, $expected, $actual);
    }
}
