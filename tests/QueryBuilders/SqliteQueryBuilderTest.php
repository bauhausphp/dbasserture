<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\Truncate;
use Bauhaus\DbAsserture\Sql\Register;
use PHPUnit\Framework\TestCase;

class SqliteQueryBuilderTest extends TestCase
{
    private QueryBuilder $queryBuilder;

    public function setUp(): void
    {
        $this->queryBuilder = new SqliteQueryBuilder();
    }

    /**
     * @test
     */
    public function buildTruncateQuery(): void
    {
        $truncateQuery = new Truncate('table');

        $query = $this->queryBuilder->build($truncateQuery);

        $expected = 'DELETE FROM "table"';
        $this->assertEquals($expected, $query);
    }

    /**
     * @test
     */
    public function buildInsertQuery(): void
    {
        $register = new Register(['id' => 1, 'field' => 'value']);
        $insert = new Insert('table', $register);

        $query = $this->queryBuilder->build($insert);

        $expected = 'INSERT INTO "table" ("id", "field") VALUES (:id, :field)';
        $this->assertEquals($expected, $query);
    }

    /**
     * @test
     */
    public function buildSelectQuery(): void
    {
        $register = new Register(['id' => 1, 'field' => 'value']);
        $insert = new Select('table', $register);

        $query = $this->queryBuilder->build($insert);

        $expected = 'SELECT "id", "field" FROM "table" WHERE "id" = :id AND "field" = :field';
        $this->assertEquals($expected, $query);
    }
}
