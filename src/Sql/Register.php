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
        $fields = [];
        foreach ($this->fields as $field) {
            $fields[] = "{$field->name()} => {$field->value()}";
        }

        return implode(', ', $fields);
    }

    /**
     * @return string[]
     */
    public function queryBinds(): array
    {
        $bindableFields = array_filter($this->fields, function (Field $field) {
            return $field->isBindable();
        });

        $binds = [];
        foreach ($bindableFields as $field) {
            $binds[$field->queryParam()] = $field->value();
        }

        return $binds;
    }

    /**
     * @return string[]
     */
    public function columns(): array
    {
        $mapper = function (Field $field) {
            return $field->name();
        };

        return array_map($mapper, $this->fields);
    }

    /**
     * @return string[]
     */
    public function queryParams(): array
    {
        $mapper = function (Field $field) {
            return $field->queryParam();
        };

        return array_map($mapper, $this->fields);
    }
}
