<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\Queries\InsertQuery;
use Bauhaus\DbAsserture\Queries\SelectQuery;
use Bauhaus\DbAsserture\Queries\TruncateQuery;

class DbAsserture
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param string|int[] $register
     */
    public function insertOne(string $table, array $register): void
    {
        $query = new InsertQuery($table, $register);

        $this->database->exec($query);
    }

    /**
     * @param string|int[][] $register
     */
    public function insertMany(string $table, array $registers): void
    {
        foreach ($registers as $register) {
            $this->insertOne($table, $register);
        }
    }

    public function cleanTable(string $table): void
    {
        $query = new TruncateQuery($table);

        $this->database->exec($query);
    }

    /**
     * @param string|int[] $register
     */
    public function assertOneIsRegistered(string $table, array $register): bool
    {
        $query = new SelectQuery($table, $register);

        $registers = $this->database->query($query);

        if (count($registers) !== 1) {
            throw new DbAssertureOneIsRegisteredFailedException($query, $registers);
        }

        return true;
    }
}
