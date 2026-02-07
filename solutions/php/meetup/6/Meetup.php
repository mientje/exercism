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

function meetup_day(int $year, int $month, string $which, string $weekday): DateTimeImmutable
{
   $day = ($which === "teenth") ? 
		findTeenthDate($year, $month, $weekday) :
      findWhich($year, $month, $weekday, $which);
 
    return new DateTimeImmutable("{$year}/{$month}/{$day}");
}

function findWhich(int $year, int $month, string $weekday, string $which) {
	 $date = new DateTimeImmutable("{$year}-{$month}");  	
	 if($date->format('l') === $weekday) {
	 	switch($which) {
			case 'first' :	 	
				return $date->format('d');
	 		case 'second' :
		 		return $date->modify('first ' . $weekday) -> format('d');
	 		case 'third' :
		 		return $date->modify('second ' . $weekday) -> format('d');
	 		case 'fourth' :
		 		return $date->modify('third ' . $weekday) -> format('d');
	 	}
  	 }
	 if($which === 'last' ) {
		$monthText = $date->format('F');
		$lastDay = $date -> modify('last day of ' . $monthText);
		return findWeekDay($lastDay, $weekday, 'previous') -> format('d');		
	 }  	 
	 return $date->modify($which . ' ' . $weekday) -> format('d');    
}

function findTeenthDate(int $year, int $month, string $weekday) {
  $firstTeenthDate = new DateTimeImmutable("{$year}-{$month}-13");
  return findWeekDay($firstTeenthDate, $weekday, 'next')-> format('j');
}

function findWeekDay($day, $weekday, $direction) {
	while($day->format('l') != $weekday ) {
   	$day = $day -> modify($direction . ' day');
  	} 
   return $day;		 
}
 
