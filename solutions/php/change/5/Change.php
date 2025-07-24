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

function findFewestCoins(array $coins, int $amount): array
{
    
    if($amount === 0) { return [];}
    elseif($amount < 0) {
        throw new InvalidArgumentException("Cannot make change for negative value.");
    }
    $smallEnough = array_filter($coins, fn($coin) => $coin <= $amount);
    if(count($smallEnough) === 0) {
        throw new InvalidArgumentException("No coins small enough to make change.");
    }

    //one of the coins in the coins array makes up the change 
    $singleCoinChange = array_values(array_filter($coins, fn($coin) => $coin === $amount));
    if(count($singleCoinChange) > 0) { 
        return $singleCoinChange; 
    }
    rsort($smallEnough);
    $change = calculateChange($smallEnough, $amount, [], $amount);

    if(array_sum($change) !== $amount) {
        throw new InvalidArgumentException("No combination can add up to target.");
    }
    return $change;
}

function calculateChange(array $coins, int $amount, array $change, int $originalAmount):array {
    $changeCoins = array_values(array_filter($coins, fn($coin) => $coin <= $amount && $coin != 1));
    if(count($changeCoins) === 0) {
        return replaceCoinsMethod($coins, $originalAmount, [], $originalAmount);
    }
    $multiplier = intdiv($amount, $changeCoins[0]);
    $change = array_merge($change, array_fill(count($change), $multiplier, $changeCoins[0]));
    $changeAmount = array_sum($change);
    $remainder = $originalAmount - $changeAmount;

    if($changeAmount === $originalAmount) {
        sort($change);
        return $change;
    }  
    // replace remainder by coins
    else { 
        return calculateChange($coins, $remainder, $change, $originalAmount);
    }
}

function replaceCoinsMethod($coins, $amount, $change, $originalAmount) : array {
    $changeCoins = array_values(array_filter($coins, fn($coin) => $coin <= $amount && $coin != 1));
    $multiplier = intdiv($amount, $changeCoins[0]);
    $change = array_merge($change, array_fill(count($change), $multiplier, $changeCoins[0]));
    $changeAmount = array_sum($change);
    $remainder = $originalAmount - $changeAmount;

    if($changeAmount === $originalAmount) {
        sort($change);
        return $change;
    }
    // replace 1 coin by smaller coin - remainder becomes bigger + find coins to replace the remainder
    $counter = count($changeCoins);
    while($counter > 0 ) {
        $maxCoin = max($change);
        $maxIndex = array_search($maxCoin, $change);
        $change[$maxIndex] = $changeCoins[1];        
        $changeAmount = array_sum($change);
        $remainder = $originalAmount - $changeAmount;
        foreach($changeCoins as $coin) {
            if($remainder % $coin === 0) {
                return calculateChange($coins, $remainder, $change, $originalAmount);
            }
        }
        $counter--;
    }
    // there's only one coin, replace that by two coins that make up the same amount
    // then one of those can be replaced by a smaller coin, remainder becomes bigger ...
    if(count($change) === 1 ) {
        $change[] = ($change[0] * 2 <= $remainder) ? $change[0] : $changeCoins[2];
        $remainder = $originalAmount - array_sum($change); 
        return replaceCoinsMethod($coins, $remainder, $change, $originalAmount);
    }
    return $change;  
}



