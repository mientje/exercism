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

class RobotSimulator
{
    private $windDirections = ['north', 'east', 'south', 'west'];

    /** @param int[] $position */
    public function __construct(array $position, string $direction)
    {
        $this->position = $position;
        $this->direction = $direction;
    }

    public function instructions(string $instructions): void
    {
        $lengte = strlen($instructions);
        for($index = 0; $index < $lengte; $index++) {
            $letter = $instructions[$index];
            $windDirIndex = array_search($this->direction, $this->windDirections);
            if($letter === 'R') {
                $windDirIndex++;
                if($windDirIndex === count($this->windDirections)) { $windDirIndex = 0;}            
            }
            elseif($letter === 'L') {
                $windDirIndex--;
                if($windDirIndex < 0) { $windDirIndex += count($this->windDirections);}
            };
            $this->direction = $this->windDirections[$windDirIndex];

            if($letter === 'A') {
                switch($this->direction) {
                    case 'north':
                        $this->position[1]++;
                        break;
                    case 'south' :
                        $this->position[1]--;
                        break;
                    case 'east' : 
                        $this->position[0]++;
                        break;
                    case 'west' :
                        $this->position[0]--;
                        break;
                }
            }
        }
    }

    /** @return int[] */
    public function getPosition(): array
    {
        return $this->position;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}
