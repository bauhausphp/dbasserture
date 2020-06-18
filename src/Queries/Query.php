<?php

namespace Bauhaus\DbAsserture\Queries;

interface Query
{
    public function table(): string;
    public function columns(): array;
    public function params(): array;
}
