<?php

namespace Bauhaus\DbAsserture\Tests;

use Bauhaus\DbAsserture\DbAssertureFactory;
use Bauhaus\DbAsserture\Database;
use Bauhaus\DbAsserture\DbAsserture;
use PDO;
use PHPUnit\Framework\TestCase;

class DbAssertureFactoryTest extends TestCase
{
    private const DB_PATH = __DIR__.'/db.sqlite';

    /**
     * @test
     */
    public function staticallyCreateDbAsserture(): void
    {
        $pdo = new PDO('sqlite:'.self::DB_PATH);
        $expected = new DbAsserture(new Database($pdo));

        $dbAsserture = DbAssertureFactory::create($pdo);

        $this->assertEquals($expected, $dbAsserture);
    }
}
