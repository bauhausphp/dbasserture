<?php

namespace Bauhaus\DbAsserture\Sql;

class Register
{
    /** @var Field[] */
    private array $fields = [];

    public function __construct(array $register)
    {
        foreach ($register as $field => $value) {
            $this->fields[] = Field::create($field, $value);
        }
    }

    public function __toString(): string
    {
        $fields = array_map(fn(Field $field) => "{$field->name()} => {$field->value()}", $this->fields);

        return implode(', ', $fields);
    }

    public function columns(): array
    {
        return array_map(fn(Field $field) => $field->name(), $this->fields);
    }

    public function queryParams(): array
    {
        return array_map(fn(Field $field) => $field->queryParam(), $this->fields);
    }

    public function queryBinds(): array
    {
        $binds = [];
        foreach ($this->bindableFields() as $field) {
            $binds[$field->queryParam()] = $field->value();
        }

        return $binds;
    }

    private function bindableFields(): array
    {
        return array_filter($this->fields, fn(Field $field) => $field->isBindable());
    }
}
