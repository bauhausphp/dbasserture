<?php

namespace Bauhaus\DbAsserture;

use PHPUnit\Framework\TestCase;

class DbAssertureMoreThanOneRegisterFoundExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function createProperMessage(): void
    {
        $table = 'db.table';
        $filters = [
            'id' => 'id-value',
            'field' => 'field-value',
        ];
        $registers = [
            ['id' => 'id-value', 'field' => 'v1'],
            ['id' => 'id-value', 'field' => 'v2'],
        ];

        $exception = new DbAssertureMoreThanOneRegisterFoundException($table, $filters, $registers);

        $expected = <<<MSG
        Not one register was queried from table "db.table" filtering by:
          id => id-value
          field => field-value
        Found registers:
        1.
          id => id-value
          field => v1
        2.
          id => id-value
          field => v2
        MSG;
        $this->assertEquals($expected, $exception->getMessage());
    }
}
