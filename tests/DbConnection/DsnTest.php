<?php

namespace Bauhaus\DbAsserture\DbConnection;

use PHPUnit\Framework\TestCase;

class DsnTest extends TestCase
{
    public function validListOfDsn(): array
    {
        return [
            'protocol://host' => [
                'protocol://host',
                [
                    'protocol' => 'protocol',
                    'user' => null,
                    'password' => null,
                    'host' => 'host',
                    'port' => null,
                    'dbname' => null,
                ],
            ],
            'protocol://host:port' => [
                'protocol://host:port',
                [
                    'protocol' => 'protocol',
                    'user' => null,
                    'password' => null,
                    'host' => 'host',
                    'port' => 'port',
                    'dbname' => null,
                ],
            ],
            'protocol://host/dbname' => [
                'protocol://host/dbname',
                [
                    'protocol' => 'protocol',
                    'user' => null,
                    'password' => null,
                    'host' => 'host',
                    'port' => null,
                    'dbname' => 'dbname',
                ],
            ],
            'protocol://user@host' => [
                'protocol://user@host',
                [
                    'protocol' => 'protocol',
                    'user' => 'user',
                    'password' => null,
                    'host' => 'host',
                    'port' => null,
                    'dbname' => null,
                ],
            ],
            'protocol://user:password@host' => [
                'protocol://user:password@host',
                [
                    'protocol' => 'protocol',
                    'user' => 'user',
                    'password' => 'password',
                    'host' => 'host',
                    'port' => null,
                    'dbname' => null,
                ],
            ],
            'protocol://user:password@host/dbname' => [
                'protocol://user:password@host/dbname',
                [
                    'protocol' => 'protocol',
                    'user' => 'user',
                    'password' => 'password',
                    'host' => 'host',
                    'port' => null,
                    'dbname' => 'dbname',
                ],
            ],
            'dbprotocol://johndoe:secret@somehost:1111/mydb' => [
                'dbprotocol://johndoe:secret@somehost:1111/mydb',
                [
                    'protocol' => 'dbprotocol',
                    'user' => 'johndoe',
                    'password' => 'secret',
                    'host' => 'somehost',
                    'port' => '1111',
                    'dbname' => 'mydb',
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validListOfDsn
     */
    public function parseDsnProperly(string $dsn, array $expected): void
    {
        $dsn = new Dsn($dsn);

        $this->assertEquals($expected, [
            'protocol' => $dsn->protocol(),
            'user' => $dsn->user(),
            'password' => $dsn->password(),
            'host' => $dsn->host(),
            'port' => $dsn->port(),
            'dbname' => $dsn->dbname(),
        ]);
    }

    public function invalidListOfDsn(): array
    {
        return [
            'invalid' => ['invalid'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidListOfDsn
     */
    public function throwInvalidArgumentExceptionIfDsnIsInvalid(string $invalidDsn): void
    {
        $this->expectException(InvalidDsnException::class);
        $this->expectExceptionMessage("Invalid DSN provided: $invalidDsn");

        new Dsn($invalidDsn);
    }
}
