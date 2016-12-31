<?php

/**
 * Generate a string of a value with lead zeros.
 *
 * @param  mixed  $value
 * @param  int  $size
 * @return string
 */
function fillWithZeros($value, $size)
{
    return str_pad($value, $size, '0', STR_PAD_LEFT);
}

/**
 * Generates an array based on an integer.
 *
 * @param  int  $number
 * @return array
 */
function reversedArrayOf($number)
{
    return array_reverse(array_map('intval', str_split($number)));
}
