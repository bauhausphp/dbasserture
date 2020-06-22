<?php

namespace Bauhaus\DbAsserture\QueryBuilders;

use Bauhaus\DbAsserture\Queries\Query;

abstract class AbstractQueryBuilder implements QueryBuilder
{
    protected const ESCAPE_CHAR = null;
    protected const QUERY_TEMPLATES = [];

    public function build(Query $query): string
    {
        $template = $this->findTemplate($query);
        $params = $this->buildParams($query);

        return $this->replaceParams($template, $params);
    }

    private function findTemplate(Query $query): string
    {
        return static::QUERY_TEMPLATES[get_class($query)];
    }

    private function buildParams(Query $query): array
    {
        $columns = $this->escapeColumns($query);
        $queryParams = $query->params();

        $where = [];
        foreach ($columns as $k => $column) {
            $where[] = "$column = {$queryParams[$k]}";
        }

        return [
            'table' => $this->escape($query->table()),
            'columns' => implode(', ', $columns),
            'params' => implode(', ', $queryParams),
            'where' => implode(' AND ', $where),
        ];
    }

    private function escapeColumns(Query $query): array
    {
        return array_map(fn(string $field) => $this->escape($field), $query->columns());
    }

    private function replaceParams(string $template, array $params): string
    {
        foreach ($params as $name => $value) {
            $template = str_replace("{{$name}}", $value, $template);
        }

        return $template;
    }

    private function escape(string $toEscape): string
    {
        return static::ESCAPE_CHAR.$toEscape.static::ESCAPE_CHAR;
    }
}