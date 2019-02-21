<?php

namespace Bauhaus\DbAsserture\Tests\Queries;

use Bauhaus\DbAsserture\Queries\TruncateQuery;
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
