<?php

namespace Bauhaus\DbAsserture\Tests;

use Bauhaus\DbAsserture\Database;
use Bauhaus\DbAsserture\DbAsserture;
use Bauhaus\DbAsserture\DbAssertureOneIsRegisteredFailedException;
use Bauhaus\DbAsserture\Queries\InsertQuery;
use Bauhaus\DbAsserture\Queries\Query;
use Bauhaus\DbAsserture\Queries\SelectQuery;
use Bauhaus\DbAsserture\Queries\TruncateQuery;
use Bauhaus\DbAsserture\Sql\Register;
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

        $this->mockDatabaseExecToBeCalledOnceWith($query);

        $this->dbAsserture->insertOne('table', ['field1' => 'value1']);
    }

    /**
     * @test
     * TODO insert more than one
     */
    public function insertManyRegistersByCallingDatabaseWithManyInsertQueries(): void
    {
        $query = new InsertQuery('table', ['field1' => 'value1']);

        $this->mockDatabaseExecToBeCalledWith([$query]);

        $this->dbAsserture->insertMany('table', [
            ['field1' => 'value1'],
        ]);
    }

    /**
     * @test
     */
    public function truncateTableByCallingDatabaseWithTruncateQuery(): void
    {
        $query = new TruncateQuery('table');

        $this->mockDatabaseExecToBeCalledOnceWith($query);

        $this->dbAsserture->cleanTable('table');
    }

    /**
     * @test
     */
    public function returnTrueIfAssertFindsRegisterInDatabase(): void
    {
        $query = new SelectQuery('table', ['field1' => 'value1']);
        $this->mockDatabaseQueryToReturnOneRegister($query, ['field1' => 'value1']);

        $result = $this->dbAsserture->assertOneIsRegistered('table', ['field1' => 'value1']);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function throwAssertOneIsRegisteredFailedExceptionIfDatabaseReturnsNoRegister(): void
    {
        $query = new SelectQuery('table', ['field1' => 'value1']);
        $this->mockDatabaseQueryToReturnNoRegister($query);

        $this->expectException(DbAssertureOneIsRegisteredFailedException::class);

        $this->dbAsserture->assertOneIsRegistered('table', ['field1' => 'value1']);
    }

    /**
     * @test
     */
    public function throwAssertOneIsRegisteredFailedExceptionIfDatabaseReturnsManyRegisters(): void
    {
        $query = new SelectQuery('table', ['field1' => 'value1']);
        $this->mockDatabaseQueryToReturnManyRegisters($query, [
            ['field1' => 'value1'],
            ['field1' => 'value2'],
        ]);

        $this->expectException(DbAssertureOneIsRegisteredFailedException::class);

        $this->dbAsserture->assertOneIsRegistered('table', ['field1' => 'value1']);
    }

    private function mockDatabaseExecToBeCalledOnceWith(Query $query): void
    {
        $this->mockDatabaseExecToBeCalledWith([$query]);
    }

    /**
     * @param Query[] $queries
     */
    private function mockDatabaseExecToBeCalledWith(array $queries): void
    {
        $count = count($queries);

        $this->database
            ->expects($this->exactly($count))
            ->method('exec')
            ->withConsecutive($queries);
    }

    private function mockDatabaseQueryToReturnOneRegister(Query $query, array $register): void
    {
        $this->mockDatabaseQueryToReturnManyRegisters($query, [$register]);
    }

    private function mockDatabaseQueryToReturnManyRegisters(Query $query, array $registers): void
    {
        /** @var Register[] $registers */
        $registers = array_map(function (array $register) {
            return new Register($register);
        }, $registers);

        $this->mockDatabaseQueryToBeCalledAndReturn($query, $registers);
    }

    private function mockDatabaseQueryToReturnNoRegister(Query $query): void
    {
        $this->mockDatabaseQueryToBeCalledAndReturn($query, []);
    }

    /**
     * @param Register[] $registers
     */
    private function mockDatabaseQueryToBeCalledAndReturn(Query $query, array $registers): void
    {
        $this->database
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn($registers);
    }
}
