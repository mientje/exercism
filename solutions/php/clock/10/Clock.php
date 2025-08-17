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

class Clock implements \Stringable
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
    private DateTimeImmutable $datetime;
    
    public function __construct(int $hours, int $minutes=0) {
        $this->datetime = new DateTimeImmutable();
        $this->modifiedTime = $this->time($hours, $minutes);
    }

    private function time(int $hours, $minutes)  {
        (int) $hours = $hours + floor($minutes/60);
        $hours = ($hours %24 < 0) ? ($hours % 24) + 24 : $hours % 24;
        $minutes = ($minutes % 60  < 0) ? ($minutes % 60) + 60 : $minutes % 60;
        $this->datetime = $this->datetime->setTime($hours, $minutes, 0);
    }
    public function add(int $minutes) : Clock {
        $this->datetime = $this->datetime->modify('+' . $minutes . ' minutes');
        return $this;
    }
    public function sub(int $minutes) : Clock {
        $this->datetime = $this->datetime->modify('-' . $minutes . ' minutes');
        return $this;
    }

    public function __toString(): string
    {
        $matches = preg_split("/:/", $this->datetime->format('H:i'));
        return sprintf("%02d:%02d", (int) $matches[0], (int) $matches[1]);  
    }
}


