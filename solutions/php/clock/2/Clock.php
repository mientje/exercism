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

class Clock
{
    /**
     * This class implements PHP's magic method __toString().
     *
     * By implementing this method, the class adheres to the `Stringable` interface.
     * When an object of this class is used in string context (e.g., echo or string cast),
     * this method is automatically called.
     *
     * More on `Stringable`: https://www.php.net/manual/en/class.stringable.php
     *
     * @return string The string representation of the Clock object
     */

    private int $hours;
    private int $minutes;
    
    public function __construct(int $hours, int $minutes=0) {
        $this->hours = $this->calcHours($hours, $minutes);
        $this->minutes = $this->calcMinutes($hours, $minutes);
    }

    private function calculate24Hours(float $time, int $divider) : float {
        return ($time < 0) ? $divider + ($time%$divider) : $time;
    }
    
    private function calcHours(int $hours, int $minutes) : int{
        $hours += floor($minutes/60);
        return $this->calculate24Hours($hours, 24) % 24;
    }

    private function calcMinutes(int $hours, int $minutes) : int {
        return $this->calculate24Hours($minutes, 60) % 60;
    }

    private function buildTimeString() : string {    
        return sprintf("%02d", $this->hours)  . ":" . sprintf("%02d", $this->minutes);
    }

    public function add(int $minutes) : string {
        $minutes += $this->minutes;
        $this->hours = $this->calcHours($this->hours, $minutes);
        $this->minutes = $this->calcMinutes($this->hours, $minutes);
        return $this->buildTimeString();
    }

    public function sub(int $minutes) : string {
        $this->minutes -= $minutes;
        $this->hours = $this->calcHours($this->hours, $this->minutes);
        $this->minutes = $this->calcMinutes($this->hours, $this->minutes);
        return $this->buildTimeString();
    }
    
    public function __toString(): string
    {
        return $this->buildTimeString();
    }
}

