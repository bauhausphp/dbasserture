<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\Queries\InsertQuery;
use Bauhaus\DbAsserture\Queries\TruncateQuery;

class DbAsserture
{
    /** @var Database */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param string[] $register
     */
    public function insertOne(string $table, array $register): void
    {
        $query = new InsertQuery($table, $register);

        $this->database->exec($query);
    }

    public function cleanTable(string $table): void
    {
        $query = new TruncateQuery($table);

        $this->database->exec($query);
    }
}
