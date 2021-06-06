<?php

namespace Bauhaus\DbAsserture;

trait ExceptionConvertingArrayToStringTrait
{
    private function arrayToString(array $arr): string
    {
        $elements = [];
        foreach ($arr as $k => $v) {
            $elements[] = "  $k => $v";
        }

        return implode("\n", $elements);
    }
}
