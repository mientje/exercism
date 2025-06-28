<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

// https://www.youtube.com/watch?v=VUg6O0tlFcA 

function rebase(int $fromBase, array $digits, int $toBase): array
{

    $result = [];

    if(validate($digits, $fromBase, $toBase)) {
        // convert $digits to number in base 10
        $power = count($digits)-1;
        $index = 0;
        while($power >= 0) {
            $digits[$index] = pow($fromBase, $power) * $digits[$index];
            $power--;
            $index++;
        }
        $decimalNum = array_sum($digits);

        // convert decimal number to $toBase
        while($decimalNum >= $toBase) {
            $remainder = $decimalNum % $toBase;   
            $decimalNum = ($decimalNum - $remainder) / $toBase;
            array_unshift($result, $remainder);
        }
        array_unshift($result, $decimalNum); 
        return $result;

    }

}

function validate(array $digits, int $fromBase, int $toBase) {

    foreach($digits as $digit) {
        if($digit < 0 || ($digit >= $fromBase && $fromBase >= 2)) { 
            throw new InvalidArgumentException('all digits must satisfy 0 <= d < input base');
        }
    }
    if($fromBase < 2) {
        throw new InvalidArgumentException('input base must be >= 2');
    }
    elseif($toBase < 2) {
        throw new InvalidArgumentException('output base must be >= 2');
    }
    return 1;

}
