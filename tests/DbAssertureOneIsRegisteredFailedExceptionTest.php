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
        $filters = [
            'id' => 'id-value',
            'field' => 'field-value',
        ];
        $expected = ['id' => 'id-value', 'field' => 'v1', 'missing' => 'm'];
        $actual = ['field' => 'v2', 'id' => 'id-value', 'added' => 'a'];

        $exception = new DbAssertureOneIsRegisteredFailedException($table, $filters, $expected, $actual);

        $expected = <<<MSG
        Not equal register found from "db.table" filtered by:
          id => id-value
          field => field-value
        Expected:
          field => v1
          id => id-value
          missing => m
        Actual:
          added => a
          field => v2
          id => id-value
        Diff:
          + added => a
          + field => v2
          - field => v1
          - missing => m
        MSG;
        $this->assertEquals($expected, $exception->getMessage());
    }
}
