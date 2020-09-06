<?php

namespace Bauhaus\DbAsserture;

use PHPUnit\Framework\TestCase;

class DbAssertureOneIsRegisteredFailedExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function createProperMessage(): void
    {
        $table = 'db.table';
        $filter = ['id' => 'id-value'];
        $expected = ['id' => 'id-value', 'field' => 'v1'];
        $actual = ['field' => 'v2', 'id' => 'id-value'];

        $exception = new DbAssertureOneIsRegisteredFailedException($table, $filter, $expected, $actual);

        $expected = <<<MSG
        Not equal register found from "db.table" filtered by:
          ['id' => 'id-value']
        Expected:
          ['id' => 'id-value', 'field' => 'v1']
        Actual:
          ['id' => 'id-value', 'field' => 'v2']
        MSG;
        $this->assertEquals($expected, $exception->getMessage());
    }
}
