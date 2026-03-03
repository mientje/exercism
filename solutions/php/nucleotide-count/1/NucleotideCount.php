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

function nucleotideCount(string $input): array
{
   $nucleotides = ['A', 'C', 'G', 'T'];	
	$result = ['a' => 0, 'c' => 0,'t' => 0, 'g' => 0 ];

	if(strlen($input) === 0) { return $result; }
	preg_match('/[^AGCT]/', $input, $falseResult);
 	if(count($falseResult) > 0) {
		throw new Exception("Invalid nucleotides");		
	}

	$splitInput = str_split($input);
	sort($splitInput);
   for($i = count($nucleotides)-1; $i >= 0; $i--) {
		$nextKey = array_search($nucleotides[$i], $splitInput); 
		if(is_int(array_search($nucleotides[$i], $splitInput))) {
			$nucleotide = array_splice($splitInput, $nextKey);
			$result[strtolower($nucleotides[$i])] = count($nucleotide);
		}
	}
	return $result;	
}
