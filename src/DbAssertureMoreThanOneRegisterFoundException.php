<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class DbAssertureMoreThanOneRegisterFoundException extends RuntimeException
{
    use ExceptionConvertingArrayToStringTrait;

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

        $string = '';
        foreach ($registers as $k => $register) {
            $number = $k + 1;
            $string .= "\n$number.\n$register";
        }

        return trim($string, "\n");
    }
}
