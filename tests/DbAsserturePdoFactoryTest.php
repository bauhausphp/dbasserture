<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\QueryBuilders\MySqlQueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\PostgreSqlQueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\QueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\SqliteQueryBuilder;
use PDO;
use PHPUnit\Framework\TestCase;

class DbAsserturePdoFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createPdoProperly(): void
    {
        $factory = new DbAsserturePdoFactory();
        $dsn = 'sqlite::memory';

        $pdo = $factory->create($dsn, null, null);

        $this->assertEquals(new PDO($dsn), $pdo);
    }
}
