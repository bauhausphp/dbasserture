<?php

namespace Bauhaus\DbAsserture\Tests\Sql;

use Bauhaus\DbAsserture\Sql\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    /**
     * @test
     */
    public function convertToAProperlySqlEscapedString(): void
    {
        $name = 'name';

        $field = new Table($name);

        $this->assertEquals("`$name`", (string) $field);
    }
}
