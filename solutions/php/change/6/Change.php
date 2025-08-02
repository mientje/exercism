<?php

declare(strict_types=1);          

function findFewestCoins(array $coins, int $amount): array
{
    
    if($amount === 0) { return [];}
    
    elseif($amount < 0) {
        throw new InvalidArgumentException("Cannot make change for negative value.");
    }
    $availableCoins = array_filter($coins, fn($coin) => $coin <= $amount);
    if(count($availableCoins) === 0) {
        throw new InvalidArgumentException("No coins small enough to make change.");
    }

    //one of the coins in the coins array makes up the change 
    $singleCoinChange = array_values(array_filter($coins, fn($coin) => $coin === $amount));
    if(count($singleCoinChange) > 0) { 
        return $singleCoinChange; 
    }
    rsort($availableCoins);
    $change = calculateChange($availableCoins, $amount, [], $amount);

    if(array_sum($change) !== $amount) {
        throw new InvalidArgumentException("No combination can add up to target.");
    }
    return $change;
}

function calculateChange(
    array $coins, 
    int $amount, 
    array $change, 
    int $originalAmount):array {
    
    $availableCoins = array_values(array_filter(
        $coins, 
        fn($coin) => $coin <= $amount && $coin != 1));
    
        if(count($availableCoins) === 0) {
    
        return calculateChangeRecombiningCoins($coins, $originalAmount, [], $originalAmount);
    }
    
    $multiplier = intdiv($amount, $availableCoins[0]);
    $change = array_merge(
        $change, 
        array_fill(count($change), $multiplier, $availableCoins[0]));
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

function calculateChangeRecombiningCoins($coins, $amount, $change, $originalAmount) : array {
    $availableCoins = array_values(
        array_filter(
            $coins, 
            fn($coin) => $coin <= $amount && $coin != 1));
    $multiplier = intdiv($amount, $availableCoins[0]);
    $change = array_merge(
        $change, 
        array_fill(count($change), $multiplier, $availableCoins[0]));

    $changeAmount = array_sum($change);
    $remainder = $originalAmount - $changeAmount;

    if($changeAmount === $originalAmount) {
        sort($change);
        return $change;
    }
    // replace 1 coin by smaller coin - remainder becomes bigger + find coins to replace the remainder
    $counter = count($availableCoins);
    while($counter > 0 ) {
        $maxCoin = max($change);
        $maxIndex = array_search($maxCoin, $change);
        $change[$maxIndex] = $availableCoins[1];        
        $changeAmount = array_sum($change);
        $remainder = $originalAmount - $changeAmount;
        foreach($availableCoins as $coin) {
            if($remainder % $coin === 0) {
                return calculateChange(
                    $coins, 
                    $remainder, 
                    $change, 
                    $originalAmount);
            }
        }
        $counter--;
    }
    // there's only one coin, replace that by two coins that make up the same amount
    // then one of those can be replaced by a smaller coin, remainder becomes bigger ...
    if(count($change) === 1 ) {
        $change[] = ($change[0] * 2 <= $remainder) 
        ? $change[0] 
        : $availableCoins[2];

        $remainder = $originalAmount - array_sum($change); 
        
        return calculateChangeRecombiningCoins(
            $coins, 
            $remainder, 
            $change, 
            $originalAmount);
    }
    return $change;  
}



