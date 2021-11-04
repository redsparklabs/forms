<?php

function colorize($number) {

    if(inbetween($number, 0, .99)) {
        return 'bg-red-900';
    }

    if(inbetween($number, 1, 1.99)) {
        return 'bg-pink-900';
    }

    if(inbetween($number, 2, 2.99)) {
        return 'bg-yellow-500';
    }

    if(inbetween($number, 3, 3.99)) {
        return 'bg-green-400';
    }

    if(inbetween($number, 4, 5)) {
        return 'bg-green-900';
    }
}

function inbetween($val, $min, $max)
{
    return ($val >= $min && $val <= $max);
}
