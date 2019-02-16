<?php

namespace Bauhaus\DbAsserture\Sql;

class Register
{
    /** @var Field[] */
    private $fields = [];

    /** @var null|string|int[] */
    private $register;

    /**
     * @param null|string|int[] $register
     */
    public function __construct(array $register)
    {
        $this->register = $register;

        foreach ($this->register as $field => $value) {
            $this->fields[] = new Field($field, $value);
        }
    }

    /**
     * @return null|string|int[]
     */
    public function queryBinds(): array
    {
        return $this->register;
    }

    /**
     * @return string[]
     */
    public function columns(): array
    {
        $mapper = function (Field $field) {
            return $field->escapedName();
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
