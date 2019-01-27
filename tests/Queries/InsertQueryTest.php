<?php

namespace Bauhaus\DbAsserture\Tests\Queries;

use Bauhaus\DbAsserture\Queries\InsertQuery;
use PHPUnit\Framework\TestCase;

class InsertQueryTest extends TestCase
{
    private const REGISTER = [
        'field1' => 'value1',
        'field2' => 'value2',
    ];

    /** @var InsertQuery */
    private $query;

    protected function setUp(): void
    {
        $this->query = new InsertQuery('table', self::REGISTER);
    }

    /**
     * @test
     */
    public function isConvertedIntoInsertQueryWithTheProvidedTableAndRegisterFields(): void
    {
        $expected = 'INSERT INTO `table` (field1,field2) VALUES (:field1,:field2)';

        $this->assertEquals($expected, (string) $this->query);
    }

    /**
     * @test
     */
    public function hasNothingToBind(): void
    {
        $this->assertEquals(self::REGISTER, $this->query->binds());
    }
}
