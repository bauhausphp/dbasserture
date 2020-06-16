<?php

namespace Bauhaus\DbAsserture\Queries;

use PHPUnit\Framework\TestCase;

class TruncateQueryTest extends TestCase
{
    /**
     * @test
     */
    public function isConvertedIntoTruncateQueryWithTheTableEscaped(): void
    {
        $truncateQuery = new TruncateQuery('table');

        $query = (string) $truncateQuery;

        $this->assertEquals('TRUNCATE table CASCADE', $query);
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
