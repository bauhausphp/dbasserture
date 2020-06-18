<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\Truncate;

final class SqliteQueryBuilder extends AbstractQueryBuilder
{
    protected const ESCAPE_CHAR = '"';
    protected const QUERY_TEMPLATES = [
        Truncate::class => 'DELETE FROM {table}',
        Insert::class => 'INSERT INTO {table} ({columns}) VALUES ({params})',
        Select::class =>  'SELECT {columns} FROM {table} WHERE {where}',
    ];
}
