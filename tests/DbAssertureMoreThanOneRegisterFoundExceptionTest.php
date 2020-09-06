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
        $filter = ['id' => 'id-value'];
        $registers = [
            ['id' => 'id-value', 'field' => 'v1'],
            ['id' => 'id-value', 'field' => 'v2'],
        ];

        $exception = new DbAssertureMoreThanOneRegisterFoundException($table, $filter, $registers);

        $expected = <<<MSG
        Not one register was queried from table "db.table" filtering by:
          ['id' => 'id-value']
        Found registers:
          ['id' => 'id-value', 'field' => 'v1']
          ['id' => 'id-value', 'field' => 'v2']
        MSG;
        $this->assertEquals($expected, $exception->getMessage());
    }
}
