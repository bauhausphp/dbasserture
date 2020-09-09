<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\DeleteAll;
use Bauhaus\DbAsserture\Sql\Register;
use PHPUnit\Framework\TestCase;

class MySqlQueryBuilderTest extends QueryBuilderTestCase
{
    public function createQueryBuilder(): QueryBuilder
    {
        return new MySqlQueryBuilder();
    }

    public function truncateQueries(): array
    {
        return [
            'without database' => [new Truncate('table'), 'TRUNCATE `table`;'],
            'with database' => [new Truncate('db.table'), 'USE `db`; TRUNCATE `table`;'],
        ];
    }

    public function insertQueries(): array
    {
        $register = new Register(['id' => 1, 'field' => 'value']);

        return [
            'without database' => [
                new Insert('table', $register),
                'INSERT INTO `table` (`id`, `field`) VALUES (:id, :field);'
            ],
            'with database' => [
                new Insert('db.table', $register),
                'USE `db`; INSERT INTO `table` (`id`, `field`) VALUES (:id, :field);'
            ],
        ];
    }

    public function selectQueries(): array
    {
        $register = new Register(['id' => 1, 'field' => 'value']);

        return [
            'without database' => [
                new Select('table', $register),
                'SELECT * FROM `table` WHERE `id` = :id AND `field` = :field;'
            ],
            'with database' => [
                new Select('db.table', $register),
                'USE `db`; SELECT * FROM `table` WHERE `id` = :id AND `field` = :field;'
            ],
        ];
    }
}
