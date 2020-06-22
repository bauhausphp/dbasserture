<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\QueryBuilders\MySqlQueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\PostgreSqlQueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\QueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\SqliteQueryBuilder;
use PDO;
use PHPUnit\Framework\TestCase;

class DbAssertureFactoryTest extends TestCase
{
    private DbAssertureFactory $factory;
    private DbAsserturePdoFactory $pdoFactory;

    public function setUp(): void
    {
        $this->pdoFactory = $this->createMock(DbAsserturePdoFactory::class);
        $this->factory = new DbAssertureFactory($this->pdoFactory);
    }

    public function sampleDsn(): array
    {
        return [
            'mysql' => [
                'mysql://sample',
                'mysql:host=sample',
                null,
                null,
                new MySqlQueryBuilder(),
            ],
            'pgsql' => [
                'pgsql://sample',
                'pgsql:host=sample',
                null,
                null,
                new PostgreSqlQueryBuilder(),
            ],
            'sqlite' => [
                'sqlite://sample',
                'sqlite:host=sample',
                null,
                null,
                new SqliteQueryBuilder(),
            ],
            'mysql with port' => [
                'mysql://sample:3306',
                'mysql:host=sample;port=3306',
                null,
                null,
                new MySqlQueryBuilder(),
            ],
            'mysql with dbname' => [
                'mysql://sample/dbname',
                'mysql:host=sample;dbname=dbname',
                null,
                null,
                new MySqlQueryBuilder()
            ],
            'mysql with user and password' => [
                'mysql://user:pass@sample/dbname',
                'mysql:host=sample;dbname=dbname',
                'user',
                'pass',
                new MySqlQueryBuilder()
            ],
            'mysql with all params' => [
                'mysql://user:pass@sample:3306/dbname',
                'mysql:host=sample;port=3306;dbname=dbname',
                'user',
                'pass',
                new MySqlQueryBuilder(),
            ],
        ];
    }

    /**
     * @test
     * @dataProvider sampleDsn
     */
    public function createDbAssertureFromDsn(
        string $dsn,
        string $expectedPdoDsn,
        ?string $expectedUser,
        ?string $expectedPassword,
        QueryBuilder $expectedQueryBuilder
    ): void {
        $pdo = $this->createMock(PDO::class);
        $this->pdoFactory
            ->expects($this->once())
            ->method('create')
            ->with($expectedPdoDsn, $expectedUser, $expectedPassword)
            ->willReturn($pdo);

        $dbAsserture = $this->factory->fromDsn($dsn);

        $expected = new DbAsserture(new DbConnection($pdo, $expectedQueryBuilder));
        $this->assertEquals($expected, $dbAsserture);
    }

    /**
     * @test
     */
    public function throwExceptionIfUnsupportedProtocolIsProvided(): void
    {
        $dsn = 'unsupported://host';

        $this->expectException(UnsupportedProtocolException::class);

        $this->factory->fromDsn($dsn);
    }
}
