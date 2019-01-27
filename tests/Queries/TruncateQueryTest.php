<?php

namespace Bauhaus\DbAsserture\Tests\Queries;

use Bauhaus\DbAsserture\Queries\TruncateQuery;
use PHPUnit\Framework\TestCase;

class TruncateQueryTest extends TestCase
{
    /**
     * @test
     */
    public function isConvertedIntoTruncateQueryWithTheProvidedTable(): void
    {
        $truncateQuery = new TruncateQuery('table');

        $this->assertEquals('TRUNCATE `table`', (string) $truncateQuery);
    }

    /**
     * @test
     */
    public function hasNothingToBind(): void
    {
        $truncateQuery = new TruncateQuery('table');

        $this->assertEmpty($truncateQuery->binds());
    }
}
