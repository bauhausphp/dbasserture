<?php

namespace Bauhaus\DbAsserture\Queries;

interface Query
{
    public function database(): ?string;
    public function table(): string;
    public function binds(): array;
}
