<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\DeleteAll;
use Bauhaus\DbAsserture\Sql\Register;
use PHPUnit\Framework\TestCase;

class DbAssertureTest extends TestCase
{
    private DbAsserture $dbAsserture;
    private DbConnection $dbConnection;

    protected function setUp(): void
    {
        $this->dbConnection = $this->createMock(DbConnection::class);
        $this->dbAsserture = new DbAsserture($this->dbConnection);
    }

    /**
     * @test
     */
    public function insertRegisterByCallingDbConnectionWithInsertQuery(): void
    {
        $query = new Insert('table', new Register(['field1' => 'value1']));

        $this->dbConnection
            ->expects($this->once())
            ->method('run')
            ->with($query);

        $this->dbAsserture->insert('table', ['field1' => 'value1']);
    }

    /**
     * @test
     */
    public function insertManyRegistersByCallingDbConnectionWithManyInsertQueries(): void
    {
        $query1 = new Insert('table', new Register(['field1' => 'value1']));
        $query2 = new Insert('table', new Register(['field2' => 'value2']));

        $this->dbConnection
            ->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive([$query1], [$query2]);

        $this->dbAsserture->insert('table', ['field1' => 'value1'], ['field2' => 'value2']);
    }

    /**
     * @test
     */
    public function truncateTableByCallingDbConnectionWithTruncateQuery(): void
    {
        $query = new DeleteAll('table');

        $this->dbConnection
            ->expects($this->once())
            ->method('run')
            ->with($query);

        $this->dbAsserture->clean('table');
    }

    /**
     * @test
     */
    public function truncateManyTablesByCallingDbConnectionWithTruncateQuery(): void
    {
        $query1 = new DeleteAll('table-1');
        $query2 = new DeleteAll('table-2');

        $this->dbConnection
            ->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive([$query1], [$query2]);

        $this->dbAsserture->clean('table-1', 'table-2');
    }

    /**
     * @test
     */
    public function selectManyRegistersByCallingDbConnectionWithSelectQuery(): void
    {
        $query = new Select('table', new Register(['id' => 'id-value']));

        $this->dbConnection
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn([
                new Register(['id' => 'id-value', 'field' => 'field-value']),
            ]);

        $register = $this->dbAsserture->select('table', ['id' => 'id-value']);

        $this->assertEquals([['id' => 'id-value', 'field' => 'field-value']], $register);
    }

    /**
     * @test
     */
    public function selectOneRegisterByCallingDbConnectionWithSelectQuery(): void
    {
        $query = new Select('table', new Register(['id' => 'id-value']));

        $this->dbConnection
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn([
                new Register(['id' => 'id-value', 'field' => 'field-value']),
            ]);

        $register = $this->dbAsserture->selectOne('table', ['id' => 'id-value']);

        $this->assertEquals(['id' => 'id-value', 'field' => 'field-value'], $register);
    }

    /**
     * @test
     */
    public function throwExceptionIfSelectOneRegisterDoesNotQueryOneResult(): void
    {
        $query = new Select('table', new Register(['id' => 'id-value']));

        $this->dbConnection
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn([
                new Register(['id' => 'id-value', 'field' => 'field-value']),
                new Register(['id' => 'id-value', 'field' => 'field-value']),
            ]);
        $this->expectException(DbAssertureMoreThanOneRegisterFoundException::class);

        $this->dbAsserture->selectOne('table', ['id' => 'id-value']);
    }

    /**
     * @test
     */
    public function returnTrueIfAssertFindsRegisterInDatabase(): void
    {
        $query = new Select('table', new Register(['id' => 'id-value']));
        $this->dbConnection
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn([
                new Register(['id' => 'id-value', 'field' => 'value']),
            ]);

        $result = $this->dbAsserture->assertOneIsRegistered('table', ['id' => 'id-value', 'field' => 'value']);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function throwAssertOneIsRegisteredFailedExceptionIfDatabaseReturnsManyRegisters(): void
    {
        $query = new Select('table', new Register(['id' => 'value']));
        $this->dbConnection
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn([new Register([]), new Register([])]);

        $this->expectException(DbAssertureMoreThanOneRegisterFoundException::class);

        $this->dbAsserture->assertOneIsRegistered('table', ['id' => 'value']);
    }

    /**
     * @test
     */
    public function throwExceptionIfAssertFindsAnotherRegisterInDatabase(): void
    {
        $query = new Select('table', new Register(['id' => 'id-value']));
        $this->dbConnection
            ->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn([
                new Register(['id' => 'id-value', 'field' => 'another-value']),
            ]);

        $this->expectException(DbAssertureOneIsRegisteredFailedException::class);

        $this->dbAsserture->assertOneIsRegistered('table', ['id' => 'id-value', 'field' => 'value']);
    }
}
