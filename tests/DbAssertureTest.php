<?php

namespace Bauhaus\DbAsserture\Tests;

use Bauhaus\DbAsserture\Queries\SelectQuery;
use StdClass;
use Bauhaus\DbAsserture\Database;
use Bauhaus\DbAsserture\DbAsserture;
use Bauhaus\DbAsserture\Queries\InsertQuery;
use Bauhaus\DbAsserture\Queries\TruncateQuery;
use Bauhaus\DbAsserture\Queries;
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

        $this->expectDatabaseExecToBeCalledWith([$query]);

        $this->dbAsserture->insertOne('table', ['field1' => 'value1']);
    }

    /**
     * @test
     * TODO insert more than one
     */
    public function insertManyRegistersByCallingDatabaseWithManyInsertQueries(): void
    {
        $query = new InsertQuery('table', ['field1' => 'value1']);

        $this->expectDatabaseExecToBeCalledWith([$query]);

        $this->dbAsserture->insertMany('table', [
            ['field1' => 'value1'],
        ]);
    }

    /**
     * @test
     */
    public function returnTrueIfAssertFindsRegisterInDatabase(): void
    {
        $query = new SelectQuery('table', ['field1' => 'value1']);
        $this->expectDatabaseQueryToBeCalledToReturn($query, ['field1' => 'value1']);

        $result = $this->dbAsserture->assertIsRegistered('table', ['field1' => 'value1']);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function truncateTableByCallingDatabaseWithTruncateQuery(): void
    {
        $query = new TruncateQuery('table');

        $this->expectDatabaseExecToBeCalledWith([$query]);

        $this->dbAsserture->cleanTable('table');
    }

    /**
     * @param Query[] $queries
     */
    private function expectDatabaseExecToBeCalledWith(array $queries): void
    {
        $count = count($queries);

        $this->database
            ->expects($this->exactly($count))
            ->method('exec')
            ->withConsecutive($queries);
    }

    private function expectDatabaseQueryToBeCalledToReturn($query, array $register): void
    {
        $this->database
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn($register);
    }
}
