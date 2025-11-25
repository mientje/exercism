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
    if(isClosingBracket($input[0])) { return false;}

    // string ends with an opening bracket
    if(isOpeningBracket($newInput[strlen($newInput)-1])) { return false;}
 
    return bracketStack($newInput);
}

function bracketStack($input) : bool {
    $stack = [];
    for($i = 0, $length = strlen($input); $i < $length; $i++) {
        $bracket = $input[$i];
        if(isOpeningBracket($bracket)) {
            $stack[] = $bracket;
            continue;
        }
        $lastBracket = $stack[count($stack)-1];      
        if(isOpeningBracket($lastBracket) && 
            $bracket === findClosingBracket($lastBracket)) {
            array_pop($stack);
        }
        else {
            return false;
        }            
    }
    return true;
}

function findMatchingBracket($char, $brackets)  {
  return match ($char) {
      $brackets[0][0] => $brackets[0][1],
      $brackets[1][0] => $brackets[1][1],
      $brackets[2][0] => $brackets[2][1],
      default => false
  };
}
function findClosingBracket($char) {
    return findMatchingBracket($char, [['{', '}'], ['[', ']' ], ['(', ')']]);
}
function isOpeningBracket($char) {
    return findMatchingBracket($char, [['{', true], ['[', true ], ['(', true]]);
}
function isClosingBracket($char) {
    return findMatchingBracket($char, [['}', true], [']', true ], [')', true ]]);
}
 