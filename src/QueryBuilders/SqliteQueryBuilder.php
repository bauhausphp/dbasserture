<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\DeleteAll;

final class SqliteQueryBuilder extends AbstractQueryBuilder
{
    protected const ESCAPE_CHAR = '"';
    protected const USE_QUERY_TEMPLATE = 'USE {db};';
    protected const QUERY_TEMPLATES = [
        Insert::class => 'INSERT INTO {table} ({columns}) VALUES ({params});',
        Select::class =>  'SELECT * FROM {table} WHERE {wheres};',
        DeleteAll::class => 'DELETE FROM {table}',
    ];
}
