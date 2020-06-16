<?php

namespace Bauhaus\DbAsserture\Tests\Queries;

use Bauhaus\DbAsserture\Queries\SelectQuery;
use PHPUnit\Framework\TestCase;

class SelectQueryTest extends TestCase
{
    private const REGISTER = [
        'field1' => 'value1',
        'field2' => null,
    ];

    private SelectQuery $query;

    protected function setUp(): void
    {
        $this->query = new SelectQuery('table', self::REGISTER);
    }

    /**
     * @test
     */
    public function isConvertedIntoSelectQueryWithTheProvidedTableAndValuesToFilter(): void
    {
        $expected = 'SELECT * FROM table WHERE field1 = :field1 AND field2 = NULL';

        $this->assertEquals($expected, (string) $this->query);
    }

    /**
     * @test
     */
    public function returnValuesToBeBound(): void
    {
        $expected = [
            ':field1' => 'value1',
        ];

        $this->assertEquals($expected, $this->query->binds());
    }
}
