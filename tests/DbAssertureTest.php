<?php

namespace Bauhaus\DbAsserture\Tests;

use Bauhaus\DbAsserture\Database;
use Bauhaus\DbAsserture\DbAsserture;
use Bauhaus\DbAsserture\Queries\InsertQuery;
use Bauhaus\DbAsserture\Queries\TruncateQuery;
use Bauhaus\DbAsserture\Query;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DbAssertureTest extends TestCase
{
    /** @var DbAsserture */
    private $dbAsserture;

    /** @var Database|MockObject */
    private $database;

    protected function setUp(): void
    {
        $this->database = $this->createMock(Database::class);
        $this->dbAsserture = new DbAsserture($this->database);
    }

    /**
     * @test
     */
    public function insertRegisterByCallingDatabaseWithInsertQuery(): void
    {
        $query = new InsertQuery('table', ['field1' => 'value1']);

        $this->expectDatabaseToBeCalledWith($query);

        $this->dbAsserture->insertOne('table', ['field1' => 'value1']);
    }

    /**
     * @test
     */
    public function truncateTableByCallingDatabaseWithTruncateQuery(): void
    {
        $query = new TruncateQuery('table');

        $this->expectDatabaseToBeCalledWith($query);

        $this->dbAsserture->cleanTable('table');
    }

    private function expectDatabaseToBeCalledWith(Query $query): void
    {
        $this->database
            ->expects($this->once())
            ->method('exec')
            ->with($query);
    }
}
