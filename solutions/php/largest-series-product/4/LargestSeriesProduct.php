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


        

          

class Series

{
    public function __construct(private string $input) {
        $this->lengte = strlen($this->input);
    }

    public function largestProduct(int $span): int
    {
        if($this->validated($span)) { 
            $index = 0;
            $largestProduct = 0;
            $nums = str_split($this->input, 1);
            while($index < $this->lengte - ($span - 1)) {
                $series = array_slice($nums, $index, $span);
                $product = array_product($series); 
                $largestProduct = max($product, $largestProduct);
                $index++;     
            }
            return $largestProduct;
        }
        return 1; 
    }

    private function validated(int $span) : bool  {

        if($span > $this->lengte) {
            throw new InvalidArgumentException("The number length is shorter than {$span}.");
        }
        elseif($span < 0) {
            throw new InvalidArgumentException("A series must be larger than zero.");
        }
        elseif(preg_match("/\D/", $this->input)) {
            throw new InvalidArgumentException("The number may not contain letters.");
        }
        return true;
    }
}