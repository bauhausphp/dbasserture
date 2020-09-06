<?php

namespace Bauhaus\DbAsserture;

trait ExceptionConvertingArrayToStringTrait
{
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
