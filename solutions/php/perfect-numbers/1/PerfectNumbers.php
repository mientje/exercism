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

// https://timesofindia.indiatimes.com/education/learning-with-toi/how-to-identify-prime-numbers-a-simple-trick-that-works-every-time/articleshow/122361795.cms

function getClassification(int $number): string
{
	if($number <= 0) {
		throw new InvalidArgumentException('Enter a number greater than zero');
	}	
		
 	elseif($number <= 2) { return "deficient"; }
 	
 	$numProperties = startSum($number);
	
   if(isPrime($number, $numProperties)) { return "deficient"; }

	$sum = calculateSum($number, $numProperties);
 	 	
	return ($sum === $number) ? "perfect" : (($sum > $number) ? "abundant" : "deficient"); 
 
}

function startSum($number) {		
	$sum = 1;
 	if($number % 2 === 0) { $sum += 2; }	
	if($number % 3 === 0) { $sum += 3; }	
 	return $sum;
}

function isPrime($number, $sum) : bool { 
	// if even or divisible by 3, 2 and 3 would have been added to the sum
	// an even number would be 3, divisible by 3 would be 4 and both even and divisible by 3 would be 6
 	if($sum !== 1) { return false; }
	$mydivider = 5; 
	$root = sqrt($number);
  	while($mydivider < $root) {		 
		if($number % $mydivider === 0) { return false; }
		$mydivider += 2;
	}
	return true;
}

function calculateSum($number, $sum)  {
	$mydivider = 4; 
  	while($mydivider <= $number/2) {		 
		if($number % $mydivider === 0) { 
			$sum += $mydivider;
		}
 		$mydivider += ($number % 2 &&  $mydivider % 2 ) ? 2 : 1;
	}
 	return $sum;
}
 
 
