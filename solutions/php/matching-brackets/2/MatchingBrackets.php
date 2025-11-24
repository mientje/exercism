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

function brackets_match(string $input): bool
{
    if(strlen($input) === 0) { return true; }

    $newInput = preg_replace('/[\w\s\\\&\^\+\*\-\.\/]/', '', $input);
    if(strlen($newInput) % 2 != 0) { 
        return false; 
    }

    $closingBracket = preg_match('/\}|\]|\)/', $newInput[0], $closingBracket);
    if($closingBracket > 0 ) { return false; }

    $openingBracket = preg_match('/\{|\[|\(/', end($newInput), $openingBracket);
    if($openingBracket > 0 ) { return false; }

    $splitInput = str_split($newInput);

    return removeMatchingBrackets($splitInput);
}

function removeMatchingBrackets($input) {
    while(count($input) > 0) {
        $i = (count($input)/2)-1;
        $openingBr = preg_match('/\{|\[|\(/', $input[$i], $typeOfBr);
        $typeOfBr = ($openingBr > 0) ? 'openingBracket' : 'closingBracket';
        $matchingBracket = findMatchingBracket($input[$i]);
        $index = $i;
        if($typeOfBr === 'openingBracket') {
            while($index >= $i && $index <= count($input)) {
                if($matchingBracket === $input[$index] ) {
                    if(count($input) === 2) { 
                        return true; 
                    }
                    elseif(($index - $i) % 2 === 0 && $index != $i) {
                        return false;
                    }
                    array_splice($input, $i, 1); 
                    array_splice($input, $index-1, 1); 
                    break;
                }
                else {
                    if($index >= count($input)) { return false; }
                    $index++;
                }
            }
        }
        else {
            while($index <= $i && $index >= 0) {
                if($matchingBracket === $input[$index] ) {
                    if(count($input) === 2) { return true; }
                    elseif(($i - $index) % 2 === 0 && $index != $i) {
                        return false;
                    }
                    array_splice($input, $i, 1); 
                    array_splice($input, $index, 1); 
                    break;
                }
                else {
                    if($index <= 0) { return false; }
                    $index--;
                }                
            }
        }
    }    
    return;

}

function findMatchingBracket($input) : string {

    $openingBr = ['{', '[', '('];
    $closingBr = ['}', ']', ')'];

    for($i = 0; $i < count($openingBr); $i++) {
        if($input === $openingBr[$i]) {
            return $closingBr[$i];
        }
        else if($input === $closingBr[$i]) {
            return $openingBr[$i];
        }
    } 
    return "no bracket found";
}
