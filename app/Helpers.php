<?php

if (!function_exists("isZeroThenReplaceOne")) {
    function isZeroThenReplaceOne($value): int
    {
        if (!is_numeric($value) || !$value) {
            return 1;
        }
        return $value;
    }
}

if (!function_exists("safeDivide")) {
    function safeDivide($divisor, $factor, $isFloat = true)
    {
        $factor = !is_numeric($factor) || !$factor ? 1 : (int)$factor;

        $divisor = !is_numeric($divisor) ? 0 : (int)$divisor;

        $number = number_format($divisor / $factor, 3);

        return $isFloat ? (float) $number : (int) $number;
    }
}
