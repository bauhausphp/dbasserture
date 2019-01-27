<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\Queries\TruncateQuery;

class DbAsserture
{
    /** @var Database */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function cleanTable(string $table): void
    {
        $query = new TruncateQuery($table);

        $this->database->exec($query);
    }
}
