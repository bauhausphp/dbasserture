<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Query;

interface QueryBuilder
{
    public function build(Query $query): string;
}
