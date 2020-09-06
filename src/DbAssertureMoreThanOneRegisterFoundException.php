<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class DbAssertureMoreThanOneRegisterFoundException extends RuntimeException
{
    private const MSG_TEMPLATE = <<<MSG_TEMPLATE
        Not one register was queried from table "{table}" filtering by:
        {filters}
        Found registers:
        {registers}
        MSG_TEMPLATE;

    public function __construct(string $table, array $filters, array $registers)
    {
        $message = str_replace('{table}', $table, self::MSG_TEMPLATE);
        $message = str_replace('{filters}', $this->convertFiltersToString($filters), $message);
        $message = str_replace('{registers}', $this->convertRegistersToString($registers), $message);

        parent::__construct($message);
    }

    private function convertFiltersToString(array $filters): string
    {
        return $this->arrayToString($filters);
    }

    private function convertRegistersToString(array $registers): string
    {
        $registers = array_map(fn(array $register) => $this->arrayToString($register), $registers);

        return implode("\n", $registers);
    }

    private function arrayToString(array $arr): string
    {
        $elements = [];
        foreach ($arr as $k => $v) {
            $elements[] = "'$k' => '$v'";
        }

        $elements = implode(', ', $elements);
        return "  [$elements]";
    }
}
