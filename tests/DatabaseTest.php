<?php

namespace Bauhaus\DbAsserture\Tests\Queries;

use Bauhaus\DbAsserture\Database;
use Bauhaus\DbAsserture\DatabaseExecException;
use Bauhaus\DbAsserture\DatabasePrepareException;
use Bauhaus\DbAsserture\Query;
use PDO;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private const DB_PATH = __DIR__.'/db.sqlite';

    /** @var Database */
    private $database;

    /** @var PDO */
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite:'.self::DB_PATH);

        $this->pdo->exec('DROP TABLE `sample`');
        $this->pdo->exec('CREATE TABLE `sample` (id INTEGER, name VARCHAR(255))');

        $this->database = new Database($this->pdo);
    }

    /**
     * @test
     */
    public function callPdoUsingProvidedQuery(): void
    {
        $expectedRegister = ['id' => 1, 'name' => 'Name'];
        $query = $this->createQueryToInsert($expectedRegister);

        $this->database->exec($query);

        $line = $this->fetchFirstLine();
        $this->assertEquals($expectedRegister, $line);
    }

    /**
     * @test
     */
    public function throwDatabaseExecExceptionIfAnErrorOccursDuringQueryExecution(): void
    {
        $query = $this->createQueryWithWrongBinds();

        $this->expectException(DatabaseExecException::class);

        $this->database->exec($query);
    }

    /**
     * @test
     */
    public function throwDatabasePrepareExceptionIfAnErrorOccursDuringQueryPreparation(): void
    {
        $query = $this->createInvalidQuery();

        $this->expectException(DatabasePrepareException::class);

        $this->database->exec($query);
    }

    /**
     * @param string|int[] $register
     */
    private function createQueryToInsert(array $register): Query
    {
        /** @var Query|MockObject $query */
        $query = $this->createMock(Query::class);

        $query
            ->method('__toString')
            ->willReturn('INSERT INTO `sample` (id, name) VALUES (:id, :name)');
        $query
            ->method('binds')
            ->willReturn($register);

        return $query;
    }

    private function createQueryWithWrongBinds(): Query
    {
        /** @var Query|MockObject $query */
        $query = $this->createMock(Query::class);

        $query
            ->method('__toString')
            ->willReturn('SELECT * FROM `sample` WHERE id = :id');
        $query
            ->method('binds')
            ->willReturn(['wrong' => 'value']);

        return $query;
    }

    private function createInvalidQuery(): Query
    {
        /** @var Query|MockObject $query */
        $query = $this->createMock(Query::class);

        $query
            ->method('__toString')
            ->willReturn('INVALID');
        $query
            ->method('binds')
            ->willReturn([]);

        return $query;
    }

    /**
     * @return string[]
     */
    private function fetchFirstLine(): array
    {
        $statement = $this->pdo->query('SELECT * FROM `sample`');

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
