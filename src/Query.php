<?php

namespace Bauhaus\DbAsserture;

interface Query
{
    public function __toString(): string;
    public function binds(): array;
}
