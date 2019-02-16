<?php

namespace Bauhaus\DbAsserture\Queries;

interface Query
{
    public function __toString(): string;

    /**
     * @return null|string|int[]
     */
    public function binds(): array;
}
