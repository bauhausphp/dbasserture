<?php

namespace Bauhaus\DbAsserture;

interface Query
{
    public function __toString(): string;

    /**
     * @return string|int[]
     */
    public function binds(): array;
}
