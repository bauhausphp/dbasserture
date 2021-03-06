<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\DeleteAll;

final class PostgreSqlQueryBuilder extends AbstractQueryBuilder
{
    protected const ESCAPE_CHAR = '"';
    protected const QUERY_TEMPLATES = [
        DeleteAll::class => 'TRUNCATE {table} CASCADE',
        Insert::class => 'INSERT INTO {table} ({columns}) VALUES ({params})',
        Select::class =>  'SELECT * FROM {table} WHERE {wheres}',
    ];
}
