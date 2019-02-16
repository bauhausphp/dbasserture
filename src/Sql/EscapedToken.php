<?php

namespace Bauhaus\DbAsserture\Sql;

abstract class EscapedToken
{
    /** @var string */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function raw(): string
    {
        return $this->token;
    }

    protected function escaped(): string
    {
        return "`{$this->token}`";
    }
}
