<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\Queries\SelectQuery;
use Bauhaus\DbAsserture\Sql\Register;
use PHPUnit\Framework\TestCase;

class DbAssertureOneIsRegisteredFailedExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function messageContainsQueryAndRegisterFoundInfo(): void
    {
        $query = new SelectQuery('table', ['field1' => 'value1', 'field2' => 'value2']);
        $registersFound = [
            new Register(['id' => 1, 'field1' => 'value1', 'field2' => 'value2']),
            new Register(['id' => 2, 'field1' => 'value1', 'field2' => 'value2']),
        ];

        $exception = new DbAssertureOneIsRegisteredFailedException($query, $registersFound);

        $expectedMessage = <<<MSG
Query '$query' with binds:
  :field1 => value1
  :field2 => value2
Returned the registers:
  id => 1, field1 => value1, field2 => value2
  id => 2, field1 => value1, field2 => value2
MSG;
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }
}
