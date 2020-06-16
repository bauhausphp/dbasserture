<?php

namespace Bauhaus\DbAsserture\Tests;

use Bauhaus\DbAsserture\DbAssertureFactory;
use Bauhaus\DbAsserture\Database;
use Bauhaus\DbAsserture\DbAsserture;
use PDO;
use PHPUnit\Framework\TestCase;

class DbAssertureFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function staticallyCreateDbAsserture(): void
    {
        $pdo = $this->createMock(PDO::class);
        $expected = new DbAsserture(new Database($pdo));

        $dbAsserture = DbAssertureFactory::create($pdo);

        $this->assertEquals($expected, $dbAsserture);
    }
}
