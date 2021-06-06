<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Query;
use PHPUnit\Framework\TestCase;

abstract class QueryBuilderTestCase extends TestCase
{
    private QueryBuilder $queryBuilder;

    protected function setUp(): void
    {
        $this->queryBuilder = $this->createQueryBuilder();
    }

    abstract protected function createQueryBuilder(): QueryBuilder;
    abstract public function queriesWithExpectedResult(): array;

    /**
     * @test
     * @dataProvider queriesWithExpectedResult
     */
    public function createQueryProperly(Query $query, string $expected): void
    {
        $this->assertEquals($expected, $this->queryBuilder->build($query));
    }
}
