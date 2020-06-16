<?php

namespace Bauhaus\DbAsserture\Tests\DbConnection;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\DbConnection\DbExecException;
use Bauhaus\DbAsserture\DbConnection\DbPrepareException;
use Bauhaus\DbAsserture\Queries\Query;
use Bauhaus\DbAsserture\Sql\Register;
use PDO;
use PHPUnit\Framework\TestCase;

class DbConnectionTest extends TestCase
{
    private DbConnection $database;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE `sample` (id INTEGER, name VARCHAR(255))');

        $this->database = new DbConnection($this->pdo);
    }

    /**
     * @test
     */
    public function execQueryByCallingPdo(): void
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
    public function queryRegistersAccordingToDatabaseSetUp(): void
    {
        $this->insertLine(1, 'Jane');
        $this->insertLine(2, 'John');
        $query = $this->createQueryToSelectAll();

        $registers = $this->database->query($query);

        $expected = [
            new Register(['id' => 1, 'name' => 'Jane']),
            new Register(['id' => 2, 'name' => 'John']),
        ];
        $this->assertEquals($expected, $registers);
    }

    /**
     * @test
     */
    public function throwDatabaseExecExceptionIfAnErrorOccursDuringQueryExecution(): void
    {
        $query = $this->createQueryWithWrongBinds();

        $this->expectException(DbExecException::class);

        $this->database->exec($query);
    }

    /**
     * @test
     */
    public function throwDatabasePrepareExceptionIfAnErrorOccursDuringQueryPreparation(): void
    {
        $query = $this->createInvalidQuery();

        $this->expectException(DbPrepareException::class);

        $this->database->exec($query);
    }

    /**
     * @param string|int[] $register
     */
    private function createQueryToInsert(array $register): Query
    {
        $query = $this->createMock(Query::class);

        $query
            ->method('__toString')
            ->willReturn('INSERT INTO `sample` (id, name) VALUES (:id, :name)');
        $query
            ->method('binds')
            ->willReturn($register);

        return $query;
    }

    private function createQueryToSelectAll(): Query
    {
        $query = $this->createMock(Query::class);

        $query
            ->method('__toString')
            ->willReturn('SELECT * FROM `sample`');
        $query
            ->method('binds')
            ->willReturn([]);

        return $query;
    }

    private function createQueryWithWrongBinds(): Query
    {
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
    private function insertLine(string $id, string $name): void
    {
        $this->pdo->exec("INSERT INTO `sample` (`id`, `name`) VALUES ($id, '$name')");
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
