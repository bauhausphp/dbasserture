<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\DbConnection\DbConnection;
use Bauhaus\DbAsserture\DbConnection\Dsn;
use Bauhaus\DbAsserture\QueryBuilders\MySqlQueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\PostgreSqlQueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\QueryBuilder;
use Bauhaus\DbAsserture\QueryBuilders\SqliteQueryBuilder;
use PDO;

class DbAssertureFactory
{
    private const QUERY_BUILDERS = [
        'sqlite' => SqliteQueryBuilder::class,
        'mysql' => MySqlQueryBuilder::class,
        'pgsql' => PostgreSqlQueryBuilder::class,
    ];

    private DbAsserturePdoFactory $pdoFactory;

    public function __construct(DbAsserturePdoFactory $pdoFactory = null)
    {
        $this->pdoFactory = $pdoFactory ?? new DbAsserturePdoFactory();
    }

    public function fromDsn(string $dsn): DbAsserture
    {
        $dsn = new Dsn($dsn);
        $dbConnection = $this->createDbConnection($dsn);

        return new DbAsserture($dbConnection);
    }

    private function createDbConnection(Dsn $dsn): DbConnection
    {
        $queryBuilder = $this->createQueryBuilder($dsn);
        $pdo = $this->createPdo($dsn);

        return new DbConnection($pdo, $queryBuilder);
    }

    private function createPdo(Dsn $dsn): PDO
    {
        $pdoDsn = "{$dsn->protocol()}:host={$dsn->host()}";
        $pdoDsn .= $dsn->port() ? ";port={$dsn->port()}" : '';
        $pdoDsn .= $dsn->dbname() ? ";dbname={$dsn->dbname()}" : '';

        return $this->pdoFactory->create($pdoDsn, $dsn->user(), $dsn->password());
    }

    private function createQueryBuilder(Dsn $dsn): QueryBuilder
    {
        $queryBuilderClass = self::QUERY_BUILDERS[$dsn->protocol()] ?? null;

        if (null !== $queryBuilderClass) {
            return new $queryBuilderClass;
        }

        $supportedProtocols = array_keys(self::QUERY_BUILDERS);
        throw new UnsupportedProtocolException($dsn->protocol(), $supportedProtocols);
    }
}
