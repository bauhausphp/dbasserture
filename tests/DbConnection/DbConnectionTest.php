<?php

namespace Bauhaus\DbAsserture\DbConnection;

use Bauhaus\DbAsserture\QueryBuilders\QueryBuilder;
use Bauhaus\DbAsserture\Sql\Register;
use PDO;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\TestCase;

class DbConnectionTest extends TestCase
{
    private DbConnection $database;
    private PDO $pdo;
    private QueryBuilder $queryBuilder;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE "sample" (id INTEGER, name VARCHAR(255))');

        $this->queryBuilder = $this->createMock(QueryBuilder::class);

        $this->database = new DbConnection($this->pdo, $this->queryBuilder);
    }

    /**
     * @test
     */
    public function execQueryByCallingPdo(): void
    {
        $expectedRegister = ['id' => 1, 'name' => 'Name'];
        $query = SampleQuery::withBinds($expectedRegister);
        $this->expectQueryBuilderToBeCalled()
            ->with($query)
            ->willReturn('INSERT INTO "sample" ("id", "name") VALUES (:id, :name)');

        $this->database->run($query);

        $this->assertEquals($expectedRegister, $this->fetchLines());
    }

    /**
     * @test
     */
    public function queryRegistersAccordingToDatabaseSetUp(): void
    {
        $this->insertLine(1, 'Jane');
        $this->insertLine(2, 'John');
        $query = new SampleQuery();
        $this->expectQueryBuilderToBeCalled()
            ->with($query)
            ->willReturn('SELECT * FROM "sample"');

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
        $query = SampleQuery::withBinds(['id' => 1]);
        $this->expectQueryBuilderToBeCalled()
            ->with($query)
            ->willReturn('SELECT * FROM "sample" WHERE id = :wrong');

        $this->expectException(DbExecException::class);

        $this->database->run($query);
    }

    /**
     * @test
     */
    public function throwDatabasePrepareExceptionIfAnErrorOccursDuringQueryPreparation(): void
    {
        $query = new SampleQuery();
        $this->expectQueryBuilderToBeCalled()
            ->with($query)
            ->willReturn('INVALID');

        $this->expectException(DbPrepareException::class);

        $this->database->run($query);
    }
    private function expectQueryBuilderToBeCalled(): InvocationMocker
    {
        return $this->queryBuilder->expects($this->once())->method('build');
    }

    private function insertLine(string $id, string $name): void
    {
        $this->pdo->exec("INSERT INTO `sample` (`id`, `name`) VALUES ($id, '$name')");
    }

    private function fetchLines(): array
    {
        $statement = $this->pdo->query('SELECT * FROM `sample`');

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
