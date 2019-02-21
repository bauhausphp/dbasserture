<?php

namespace Bauhaus\DbAsserture\Sql;

class EscapedToken
{
    /** @var string */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function __toString(): string
    {
        return "`{$this->token}`";
    }
}
