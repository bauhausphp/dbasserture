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
        Diff:
        {diff}
        MSG_TEMPLATE;

    public function __construct(string $table, array $filter, array $expected, array $actual)
    {
        ksort($expected);
        ksort($actual);
        $diff = $this->diff($expected, $actual);

        $message = str_replace('{table}', $table, self::MSG_TEMPLATE);
        $message = str_replace('{filters}', $this->arrayToString($filter), $message);
        $message = str_replace('{expected}', $this->arrayToString($expected), $message);
        $message = str_replace('{actual}', $this->arrayToString($actual), $message);
        $message = str_replace('{diff}', $this->arrayToString($diff), $message);

        parent::__construct($message);
    }

    private function diff(array $expected, array $actual): array
    {
        $missingFields = array_diff($expected, $actual);
        $addedFields = array_diff($actual, $expected);

        $allDiffKeys = array_merge(array_keys($missingFields), array_keys($addedFields));
        $allDiffKeys = array_unique($allDiffKeys);
        sort($allDiffKeys);

        $diff = [];
        foreach ($allDiffKeys as $k) {
            $added = $addedFields[$k] ?? null;
            $missing = $missingFields[$k] ?? null;

            $diff["+ $k"] = $added;
            $diff["- $k"] = $missing;
        }

        return array_filter($diff);
    }
}
