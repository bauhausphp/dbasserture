<?php

namespace Bauhaus\DbAsserture\Tests;

use Bauhaus\DbAsserture\Database;
use Bauhaus\DbAsserture\DbAsserture;
use Bauhaus\DbAsserture\Queries\TruncateQuery;
use Bauhaus\DbAsserture\Query;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DbAssertureTest extends TestCase
{
    /** @var DbAsserture */
    private $dbAsserture;

    /** @var Database|MockObject */
    private $database;

    protected function setUp(): void
    {
        $this->database = $this->createMock(Database::class);
        $this->dbAsserture = new DbAsserture($this->database);
    }

    /**
     * @test
     */
    public function truncateTableByCallingDatabaseWithTruncateQuery(): void
    {
        $truncateQuery = new TruncateQuery('table');

        $this->mockDatabaseToBeCalled($truncateQuery);

        $this->dbAsserture->cleanTable('table');
    }

    private function mockDatabaseToBeCalled(Query $query): void
    {
        $this->database
            ->expects($this->once())
            ->method('exec')
            ->with($query);
    }
}
