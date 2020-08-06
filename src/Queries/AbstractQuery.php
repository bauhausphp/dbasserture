<?php

namespace Bauhaus\DbAsserture\Queries;

use Bauhaus\DbAsserture\Sql\Register;

abstract class AbstractQuery implements Query
{
    private ?string $database;
    private string $table;
    private ?Register $register;

    public function __construct(string $table, Register $register = null)
    {
        [$this->database, $this->table] = $this->extractDatabaseAndTable($table);
        $this->register = $register;
    }

    public function database(): ?string
    {
        return $this->database;
    }

    public function table(): string
    {
        return $this->table;
    }

    public function columns(): array
    {
        return $this->hasRegister() ? $this->register->columns() : [];
    }

    public function params(): array
    {
        return $this->hasRegister() ? $this->register->queryParams() : [];
    }

    public function binds(): array
    {
        return $this->hasRegister() ? $this->register->queryBinds() : [];
    }

    private function hasRegister(): bool
    {
        return null !== $this->register;
    }

    private function extractDatabaseAndTable(string $table): array
    {
        $tableParts = explode('.', $table);

        return [
            count($tableParts) > 1 ? $tableParts[0] : null,
            count($tableParts) > 1 ? $tableParts[1] : $tableParts[0],
        ];
    }
}
