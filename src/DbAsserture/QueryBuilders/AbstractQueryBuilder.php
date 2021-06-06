<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Insert;
use Bauhaus\DbAsserture\Queries\Query;
use Bauhaus\DbAsserture\Queries\Select;

abstract class AbstractQueryBuilder implements QueryBuilder
{
    protected const ESCAPE_CHAR = null;
    protected const QUERY_TEMPLATES = [];

    public function build(Query $query): string
    {
        $template = $this->determineTemplate($query);
        $params = $this->buildPlaceholders($query);

        return $this->replacePlaceholders($template, $params);
    }

    private function determineTemplate(Query $query): string
    {
        return static::QUERY_TEMPLATES[get_class($query)];
    }

    private function buildPlaceholders(Query $query): array
    {
        $placeholders = $this->specificPlaceholders($query);

        return array_merge($placeholders, [
            'db' => $query->database() ? $this->escape($query->database()) : null,
            'table' => $this->escape($query->table()),
        ]);
    }

    private function specificPlaceholders(Query $query): array
    {
        if ($query instanceof Insert) {
            return [
                'columns' => implode(', ', array_map(fn(string $field) => $this->escape($field), $query->columns())),
                'params' => implode(', ', $query->params()),
            ];
        }

        if ($query instanceof Select) {
            $wheres = array_map(
                fn(string $column, string $value) => "{$this->escape($column)} = $value",
                array_keys($query->filters()),
                $query->filters(),
            );

            return [
                'wheres' => implode(' AND ', $wheres),
            ];
        }

        return [];
    }

    private function replacePlaceholders(string $template, array $params): string
    {
        foreach ($params as $name => $value) {
            $template = str_replace("{{$name}}", $value, $template);
        }

        return $template;
    }

    private function escape(string $toEscape): string
    {
        return static::ESCAPE_CHAR . $toEscape . static::ESCAPE_CHAR;
    }
}
