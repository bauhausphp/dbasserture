<?php

namespace Bauhaus\DbAsserture\Queries;

abstract class AbstractQuery implements Query
{
    private ?string $database;
    private string $table;

    public function __construct(string $table)
    {
        [$this->database, $this->table] = $this->extractDatabaseAndTable($table);
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
        return [];
    }

    public function params(): array
    {
        return [];
    }

    public function binds(): array
    {
        return [];
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
