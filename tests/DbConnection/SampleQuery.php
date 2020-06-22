<?php

namespace Bauhaus\DbAsserture\DbConnection;

use Bauhaus\DbAsserture\Queries\Query;

class SampleQuery implements Query
{
    private array $binds = [];

    public static function withBinds(array $binds): Query
    {
        $self = new self();
        $self->binds = $binds;

        return $self;
    }

    public function table(): string
    {
        return 'dummy-table';
    }

    public function columns(): array
    {
        return [];
    }

    public function params(): array
    {
        return [];
    }

    public function binds(): array
    {
        return $this->binds;
    }
}
