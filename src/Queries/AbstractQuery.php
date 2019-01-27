<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Query;

abstract class AbstractQuery implements Query
{
    /** @var string */
    private $table;

    /** @var string|int[] */
    private $register;

    /**
     * @param string|int[] $register
     */
    public function __construct(string $table, array $register)
    {
        $this->table = $table;
        $this->register = $register;
    }

    /**
     * @param string|int[] $register
     */
    public function binds(): array
    {
        return $this->register;
    }

    protected function table(): string
    {
        return $this->table;
    }

    /**
     * @param string|int[] $register
     */
    protected function register(): array
    {
        return $this->register;
    }
}
