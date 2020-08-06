<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\Truncate;

final class PostgreSqlQueryBuilder extends AbstractQueryBuilder
{
    protected const ESCAPE_CHAR = '"';
    protected const USE_QUERY_TEMPLATE = 'USE {db};';
    protected const QUERY_TEMPLATES = [
        Truncate::class => 'TRUNCATE {table} CASCADE;',
        Insert::class => 'INSERT INTO {table} ({columns}) VALUES ({params});',
        Select::class =>  'SELECT {columns} FROM {table} WHERE {where};',
    ];
}
