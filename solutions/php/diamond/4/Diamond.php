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

function diamond(string $letter): array
{
    $alphabet = range('A', $letter);
    $topDiamond = [];

    for($index = 0, $lengte = count($alphabet)-1, $sidePadding = count($alphabet)-1; 
        $index <= $lengte; $index++, $sidePadding-- ) {
        $curLetter = $alphabet[$index];
        $lineLength = ($lengte * 2) + 1;
        $diamondString = $curLetter . str_pad('', $lineLength - ($sidePadding * 2) - 2, ' ', STR_PAD_RIGHT) . $curLetter;
        $diamondLine = ($index === 0) ?
            str_pad($curLetter, $lineLength, " ", STR_PAD_BOTH) :
            str_pad($diamondString, strlen($diamondString) + $sidePadding*2, ' ', STR_PAD_BOTH);
        $topHalf[] = $diamondLine;        
    }
    return bottomHalf($topHalf);
}

function bottomHalf($diamond) : array {
    $bottomHalf = array_reverse($diamond);
    array_shift($bottomHalf);
    return array_merge($diamond, $bottomHalf);
}