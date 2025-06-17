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

function countLetters($matches) {
    $matchLength = strlen($matches[0]);
    $output = ($matchLength === 1) ? $matches[0][0] : $matchLength . $matches[0][0];
    echo "countLetters output {$output} \n";
    return $output;
}


function encode(string $input): string
{
    $output = '';
    while(strlen($input) > 0) {
        $pattern = "/$input[0]+/";
        $output = preg_replace_callback($pattern, function($matches, $input) {
            $matchLength = strlen($matches[0]);
            $input = substr_replace($input, '', 0, $matchLength);
            return ($matchLength === 1) ? $matches[0][0] : $matchLength . $matches[0][0];
        }, $input);
    

        echo "encode output {$output} \n";
    }
    return $output;
}

function decode(string $input): string
{
    $output = "";
    $repeatingChars = preg_split('/(\d*\D|\d*\s)/', $input, strlen($input), PREG_SPLIT_DELIM_CAPTURE);
    foreach($repeatingChars as $key => $value) {
        if(strlen($value) > 0 ) {
            $letter = substr($value, -1);
            $repeater = substr($value, 0, -1);
            if(strlen($repeater) === 0) { $repeater = 1; }
            while($repeater > 0) {
                $output .= $letter;
                $repeater--;
            }
        }
    }
    return $output;    
}
