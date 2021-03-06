<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Select;
use Bauhaus\DbAsserture\Queries\DeleteAll;
use Bauhaus\DbAsserture\Sql\Register;

class MySqlQueryBuilderTest extends QueryBuilderTestCase
{
    public function createQueryBuilder(): QueryBuilder
    {
        return new MySqlQueryBuilder();
    }

    public function queriesWithExpectedResult(): array
    {
        $register = new Register(['id' => 1, 'field' => 'value']);

        return [
            'delete all' => [new DeleteAll('table'), 'DELETE FROM `table`'],
            'insert' => [new Insert('table', $register), 'INSERT INTO `table` (`id`, `field`) VALUES (:id, :field)'],
            'select' => [new Select('table', $register), 'SELECT * FROM `table` WHERE `id` = :id AND `field` = :field'],
        ];
    }
}
