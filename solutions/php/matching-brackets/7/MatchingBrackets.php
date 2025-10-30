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

    //get rid of all the confusion and stuff that is not a bracket
    $newInput = preg_replace('/[^\(\)\{\}\[\]]/', '', $input);

    // the length of the string is not an even number, 
    // so there's a bracket without its match in there
    if(strlen($newInput) % 2 != 0) { return false; }

    // string starts with a closing bracket
    if(str_starts_with($newInput[0], '}'|']'|')' )) { return false; }

    // string ends with an opening bracket
    if(str_ends_with($newInput[strlen($newInput)-1], '{'|'['|'(' )) { return false; }

    return removeMatchingBrackets($newInput);
}

function removeMatchingBrackets($input) {
    while(strlen($input) > 0 ) {
       
        $closingBracket = findMatchingBracket($input[0]);
        preg_match_all('/' .preg_quote($closingBracket) . '/', 
            $input, $closingBrackets, PREG_OFFSET_CAPTURE);
        $lastClosingIndex = end($closingBrackets[0])[1];

        // openingbracket is immediately followed by 
        // matching closing bracket
        if($input[1] === $closingBracket) {
            $input = substr($input, 2); 
            continue;
        } 
        // opening bracket is followed by all 
        // kinds of other brackets
        elseif($lastClosingIndex % 2 !== 0) {
            $input = substr($input, 1,  $lastClosingIndex-1); 
            continue;
        }
        // opening bracket is followed by all kinds of other brackets - 
        // if there's an odd number between opening and corresponding 
        // closing bracket, there are no pairs between them and there's a mistake
        else {
            return false;
        }
    }
    return true;
}

function findMatchingBracket($bracket) : string {
    switch($bracket) {
        case '{' : return '}';
        case '[' : return ']';
        case '(' : return ')';
    }
}
