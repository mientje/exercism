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

class GradeSchool
{
    private $grades = [];

    public function add(string $name, int $grade): bool
    {
        if($this->findStudent($name)) {    
            return false;
        } 
        $this->grades[$grade][] = $name; 
        $this->roster($name, $grade);
        return true;
    }

    public function grade(int $grade): array
    {
        foreach($this->grades as $key => $names) {
            if($key === $grade) {
                sort($names);
                return $names;
            }
        }
        return [];
        
    }

    public function roster(): array
    {     
        $roster = [];   
        ksort($this->grades);
        foreach($this->grades as $grade => $name) {
            sort($name);
            foreach($name as $value) {
                $roster[] = $value;
            }
        }
        //echo "roster \n";
        //print_r($roster);
        return $roster;
    }

    public function findStudent($name): bool
    {
        foreach ($this->grades as $grade => $students) {
            foreach($students as $key => $value)
            if($value === $name) {
                return true;
            }            
        }        
        return false;
    }

}

