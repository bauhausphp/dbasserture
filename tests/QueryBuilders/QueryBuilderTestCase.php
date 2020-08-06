<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\Truncate;
use PHPUnit\Framework\TestCase;

abstract class QueryBuilderTestCase extends TestCase
{
    private QueryBuilder $queryBuilder;

    protected function setUp(): void
    {
        $this->queryBuilder = $this->createQueryBuilder();
    }

    abstract protected function createQueryBuilder(): QueryBuilder;
    abstract protected function truncateQueries(): array;
    abstract protected function insertQueries(): array;
    abstract protected function selectQueries(): array;

    /**
     * @test
     * @dataProvider truncateQueries
     */
    public function buildTruncateQuery(Truncate $query, string $expected): void
    {
        $this->assertEquals($expected, $this->queryBuilder->build($query));
    }

    /**
     * @test
     * @dataProvider insertQueries
     */
    public function buildInsertQuery(Insert $query, string $expected): void
    {
        $this->assertEquals($expected, $this->queryBuilder->build($query));
    }

    /**
     * @test
     * @dataProvider selectQueries
     */
    public function buildSelectQuery(Select $query, string $expected): void
    {
        $this->assertEquals($expected, $this->queryBuilder->build($query));
    }
}
