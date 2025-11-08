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
    $date = ($which === "teenth") ? 
        findTeenthDate($year, $month, $weekday) :
        findWhich($year, $month, $weekday, $which);

    return new DateTimeImmutable($year . '/' . $month . '/' . $date);
}

function findWhich(int $year, int $month, string $weekday, string $which) {
    $date = new DateTimeImmutable($year . '-' . $month);
    $whichDay = "";
    $dateWeekDay = $date->format('l');
 
    switch($which) {
      case "first" :
        $whichDay = ($dateWeekDay === $weekday) ? null : $which;
        break;
      case "second" : 
        $whichDay = ($dateWeekDay === $weekday) ? "first" : $which; 
        break;
      case "third" : 
        $whichDay = ($dateWeekDay === $weekday) ? "second" : $which;  
        break;
      case "fourth" : 
        $whichDay = ($dateWeekDay === $weekday) ? "third" : $which;
        break;
      case "last" : 
        if($month === 2) {
          $whichDay = ($date->modify("fourth " . $weekday)->format('m') != $month ) ? "third" : "fourth";
        }
        else {
          $whichDay = ($date->modify("fifth " . $weekday)->format('m') != $month ) ? "fourth" : "fifth";
        }
    }

    return ($whichDay === null) ? 
      $date->format('d') : 
      $date->modify($whichDay . " " . $weekday)->format('d'); 

}

function findTeenthDate(int $year, int $month, string $weekday) {
    $firstTeenthDate = new DateTimeImmutable($year . '-' . $month . '-13');
    $teenthDays = createTeenthArray($firstTeenthDate->format('l'));
    return $teenthDays[$weekday];
}

function createTeenthArray($firstTeenthDay) {
    $weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $teenthDays = [];
    $teenth = 13;
    $firstWeekDay = array_search($firstTeenthDay, $weekdays);
    $days = 0;
    while($days < 7) {
        if($firstWeekDay === 7) { $firstWeekDay = 0; }
        $teenthDays[$weekdays[$firstWeekDay]] = $teenth;
        $teenth++;
        $firstWeekDay++;
        $days++;
    }
    return $teenthDays;
}
