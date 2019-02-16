<?php

namespace Bauhaus\DbAsserture\Tests\Sql;

use Bauhaus\DbAsserture\Sql\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    /**
     * @test
     */
    public function convertToAProperlySqlEscapedString(): void
    {
        $name = 'name';
        $value = 'value';

        $field = new Field($name, $value);

        $this->assertEquals("`$name`", $field->escapedName());
    }
}
