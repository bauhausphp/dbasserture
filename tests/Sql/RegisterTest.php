<?php

namespace Bauhaus\DbAsserture\Tests\Sql;

use Bauhaus\DbAsserture\Sql\Register;
use Bauhaus\DbAsserture\Sql\SqlExpression;
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    /** @var Register */
    private $register;

    protected function setUp(): void
    {
        $this->register = new Register([
            'id' => 81245,
            'name' => 'John Doe',
            'extra' => new SqlExpression('SQL_EXPRESSION'),
        ]);
    }

    /**
     * @test
     */
    public function returnAllColumnsProperlyEscaped(): void
    {
        $columns = $this->register->columns();

        $this->assertEquals(['`id`', '`name`', '`extra`'], $columns);
    }

    /**
     * @test
     */
    public function returnAllQueryParams(): void
    {
        $queryParams = $this->register->queryParams();

        $this->assertEquals([':id', ':name', 'SQL_EXPRESSION'], $queryParams);
    }

    /**
     * @test
     */
    public function returnAllQueryBinds(): void
    {
        $binds = $this->register->queryBinds();

        $this->assertEquals([':id' => '81245', ':name' => 'John Doe'], $binds);
    }
}
