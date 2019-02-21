<?php

namespace Bauhaus\DbAsserture;

use Bauhaus\DbAsserture\Queries\Query;
use Bauhaus\DbAsserture\Sql\Register;
use RuntimeException;

class DbAssertureOneIsRegisteredFailedException extends RuntimeException
{
    private const MESSAGE = "Query '%s' with binds:%s\nReturned the registers:%s";

    /**
     * @param Register[] $registersFound
     */
    public function __construct(Query $query, array $registersFound)
    {
        $binds = $this->queryBindsAsString($query);
        $registersFound = $this->registersAsString($registersFound);

        parent::__construct(sprintf(self::MESSAGE, $query, $binds, $registersFound));
    }

    private function queryBindsAsString(Query $query): string
    {
        $binds = '';
        foreach ($query->binds() as $param => $value) {
            $binds .= "\n  $param => $value";
        }

        return $binds;
    }

    /**
     * @param Register[] $registersFound
     */
    private function registersAsString(array $registersFound): string
    {
        $registers = '';
        foreach ($registersFound as $register) {
            $registers .= "\n  $register";
        }

        return $registers;
    }
}
