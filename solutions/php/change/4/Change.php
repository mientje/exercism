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

    $reversedCoins = array_reverse($smallEnough);
    foreach($reversedCoins as $coin) {
        $change[] = calculateChange($reversedCoins, 0, $amount, [], $amount);
        array_shift($reversedCoins);
    }
    $result = sortShortestArray($change);
    if($result === [-1]) {
        throw new InvalidArgumentException("No combination can add up to target.");
    }

    return $result;
}

function sortShortestArray($change) : array {
    $lengte = count($change);

    if($lengte === 0 ) { return $change; }

    $validChanges = array_filter($change, fn($coins) => $coins != [-1]);
    $shortestChange = array_reduce($validChanges, fn($curch, $ch) => 
        (count($ch) < count($curch)) ? $ch : $curch ,$change[0]);
    sort($shortestChange);

    return $shortestChange;
}

function calcChangeAmount($change) {
    $lengte = count($change);
    return ($lengte === 0 ? 0 : $lengte === 1) ? $change[0] : array_sum($change);
}

function calculateChange(array $coins, int $start, int $amount, array $change, int $originalAmount):array {
    $lengte = count($coins)-1;     
    $coin = $coins[$start];
    $divided = intdiv($amount, $coin);
    $remainder = $amount - ($divided * $coin);
    $change = array_merge($change, array_fill(count($change), $divided, $coin));
    $changeAmount = calcChangeAmount($change);
    if($changeAmount == $originalAmount) { return $change; }
    $start += 1;
    if($start > $lengte) { return [-1]; }
    if($changeAmount > $originalAmount 
        || $changeAmount + $coins[$lengte] > $originalAmount) {
        array_pop($change);
        array_push($change, $coins[$start], $coins[$start]);
        $changeAmount = calcChangeAmount($change);
        if($start+1 > $lengte && $changeAmount > $originalAmount)  {
            $index = array_search($coins[$start-1], $change);
            array_splice($change, $index, 1);
        }
        $changeAmount = calcChangeAmount($change);
        $amount = $originalAmount - $changeAmount;
        return calculateChange($coins, $start, $amount, $change, $originalAmount);
    }      
    return calculateChange($coins, $start, $remainder, $change, $originalAmount);
}