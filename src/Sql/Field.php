<?php

namespace Bauhaus\DbAsserture\Sql;

class Field extends EscapedToken
{
    /** @var string */
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->value = $value;

        parent::__construct($name);
    }

    public function escapedName(): string
    {
        return $this->escaped();
    }

    public function queryParam(): string
    {
        return ":{$this->raw()}";
    }
}
