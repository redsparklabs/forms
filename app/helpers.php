<?php

/**
 * Colorize
 *
 * @param  integer $number
 * @return string|null
 */
if (!function_exists('colorize')) {
    function colorize($number)
    {

        if (inbetween($number, 0, .99)) {
            return 'bg-red-900';
        }

        if (inbetween($number, 1, 1.99)) {
            return 'bg-pink-900';
        }

        if (inbetween($number, 2, 2.99)) {
            return 'bg-yellow-500';
        }

        if (inbetween($number, 3, 3.99)) {
            return 'bg-green-400';
        }

        if (inbetween($number, 4, 5)) {
            return 'bg-green-900';
        }

        return null;
    }
}

/**
 * Check if a number is between two other numbers
 *
 * @param  integer $val
 * @param  integer $min
 * @param  float $max
 * @return bool
 */
if (!function_exists('inbetween')) {
    function inbetween($val, $min, $max)
    {
        return ($val >= $min && $val <= $max);
    }
}
