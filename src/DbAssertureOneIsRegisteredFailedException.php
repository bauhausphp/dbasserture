<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class DbAssertureOneIsRegisteredFailedException extends RuntimeException
{
    use ExceptionConvertingArrayToStringTrait;

    private const MSG_TEMPLATE = <<<MSG_TEMPLATE
        Not equal register found from "{table}" filtered by:
        {filters}
        Expected:
        {expected}
        Actual:
        {actual}
        MSG_TEMPLATE;

    public function __construct(string $table, array $filter, array $expected, array $actual)
    {
        asort($expected);
        asort($actual);

        $message = str_replace('{table}', $table, self::MSG_TEMPLATE);
        $message = str_replace('{filters}', $this->arrayToString($filter), $message);
        $message = str_replace('{expected}', $this->arrayToString($expected), $message);
        $message = str_replace('{actual}', $this->arrayToString($actual), $message);

        parent::__construct($message);
    }
}
