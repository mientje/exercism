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

function crypto_square(string $plaintext): string
{
    $lowerChars = strtolower($plaintext);
    $noSpaces = preg_replace('/\W*/', '', $lowerChars);

    $lengte = strlen($noSpaces);
    if($lengte === 0 ) { return "";}
    elseif($lengte < 2) { return $noSpaces; }
    
    $divider = defineRowsColumns($lengte);
    $splitText = str_split($noSpaces, $divider);

    $square = "";
    $lastRow = end($splitText);
    $extraSpaces = strlen($splitText[0]) - strlen($lastRow);
    while($extraSpaces > 0) {
        $lastRow .= " ";
        $extraSpaces--;
    }
    $splitText[count($splitText)-1] = $lastRow;

    $i = 0;
    while($i < $divider) {
        foreach($splitText as $chunk) {
            $square .= $chunk[$i];
        }
        if($i < $divider-1) {
            $square .= " ";
        }
        $i++;
    }
    return $square;
}

function defineRowsColumns(int $lengte) : int {
    $columns = 2;
    $rows = 1;
    while($rows * $columns < $lengte) {
        $columns++;
        $rows++;
        if($rows * $columns >= $lengte) {
            break;
        }
    }
    $rowDivider = substr(strval($lengte - $rows * $rows), -1);
    $colDivider = substr(strval($lengte - $rows * $columns), -1);
    return ($lengte - $rowDivider > $lengte - $colDivider ) ?  $rows : $columns; 
}