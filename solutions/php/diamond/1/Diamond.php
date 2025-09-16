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

    for($index = 0, $lengte = count($alphabet)-1; $index <= $lengte; $index++ ) {
        $curLetter = $alphabet[$index];
        $leftHand = str_repeat(' ', $lengte - $index ); 
        $rightHand = ($curLetter === 'A') ? '' : str_repeat(' ', ($index * 2) -1);
        $diamondLine = ($index === 0) ? 
            $leftHand . $curLetter . $leftHand :
            $leftHand . $curLetter . $rightHand . $curLetter . $leftHand;
        $topDiamond[] = $diamondLine;        
    }
    return upsideDown($topDiamond);
    
}

function upsideDown($diamond) : array {
    $index = count($diamond)-2; 
    while($index >= 0) {
        $diamond[] = $diamond[$index];
        $index--;
    }
    return $diamond;
}

