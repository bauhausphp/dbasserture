<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\QueryBuilders\QueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\SqliteQueryBuilder;
use PDO;
use PHPUnit\Framework\TestCase;

class SqliteDbAssertureTest extends TestCase
{
    private DbAsserture $dbAsserture;
    private PDO $pdo;
    private QueryBuilder $queryBuilder;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE "sample" (id INTEGER, name VARCHAR(255))');
        $this->queryBuilder = new SqliteQueryBuilder();
        $this->dbAsserture = new DbAsserture(new DbConnection($this->pdo, $this->queryBuilder));
    }

    /**
     * @test
     */
    public function truncateSqliteTableProperly(): void
    {
        $this->insertLine(1, 'Jane');
        $this->insertLine(2, 'John');

        $this->dbAsserture->cleanTable('sample');

        $this->assertEmpty($this->fetchLines());
    }

    /**
     * @test
     */
    public function insertOneRegistryInSqliteProperly(): void
    {
        $expected = [
            ['id' => '1', 'name' => 'Name'],
        ];

        $this->dbAsserture->insertOne('sample', ['id' => 1, 'name' => 'Name']);

        $this->assertEquals($expected, $this->fetchLines());
    }

    /**
     * @test
     */
    public function insertManyRegistryInSqliteProperly(): void
    {
        $expected = [
            ['id' => '1', 'name' => 'John'],
            ['id' => '2', 'name' => 'Jane'],
        ];

        $this->dbAsserture->insertMany('sample', [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
        ]);

        $this->assertEquals($expected, $this->fetchLines());
    }

    /**
     * @test
     */
    public function selectOneRegister(): void
    {
        $this->insertLine(1, 'Jane');
        $this->insertLine(2, 'John');

        $selectedRegister = $this->dbAsserture->selectOne('sample', ['id' => 1]);

        $expected = ['id' => '1', 'name' => 'Jane'];
        $this->assertEquals($expected, $selectedRegister);
    }

    /**
     * @test
     */
    public function returnTrueIfRegistryToAssertIsInDatabase(): void
    {
        $this->insertLine(1, 'John');

        $result = $this->dbAsserture->assertOneIsRegistered('sample', ['id' => 1, 'name' => 'John']);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function throwExceptionIfThereIsNoRegistryToAssertInDatabase(): void
    {
        $this->insertLine(1, 'John');

        $this->expectException(DbAssertureAnotherRegisterFoundException::class);

        $this->dbAsserture->assertOneIsRegistered('sample', ['id' => 1, 'name' => 'Jane']);
    }

    private function insertLine(string $id, string $name): void
    {
        $this->pdo->exec("INSERT INTO \"sample\" (\"id\", \"name\") VALUES ($id, '$name')");
    }

    private function fetchLines(): array
    {
        $statement = $this->pdo->query('SELECT * FROM "sample"');

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
