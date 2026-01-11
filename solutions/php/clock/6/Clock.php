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
    private object $datetime;
    
    public function __construct(int $hours, int $minutes=0) {
        $this->hours = $this->recalculateHours($hours, $minutes);
        $this->minutes = $this->recalculateMinutes($minutes);
        $this->datetime = $this->time();
    }
    
    private function recalculateHours(int $hours, $minutes) : int {
        (int) $hours  = $hours + (floor($minutes/60));
        if($hours < 0) { $hours = 24 + ($hours % 24);}
        return $hours % 24;
    }
    private function recalculateMinutes($minutes) :int {
        if($minutes < 0) { $minutes = 60 + ($minutes % 60);}
        return $minutes % 60;
    }

    private function time(): object {
        $datetime = new DateTimeImmutable();
        return $datetime->setTime((int) $this->hours, $this->minutes, 0);
    }

    public function add(int $minutes) : object {
        return $this->datetime->add(new DateInterval('PT' . $minutes . 'M'));
    }

    public function sub(int $minutes) : object {
        $this->datetime->sub(new DateInterval('PT' . $minutes . 'M')); 
    }

    public function __toString(): string
    {
        return $this->datetime->format('H:i'); 
    }
}