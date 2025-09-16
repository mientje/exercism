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

function winner(array $lines): ?string
{
    $emptyBoard = true;

    if(count($lines) === 1) {
        if ($lines[0] === "X") { return "black"; }
        elseif($lines[0] === "O") { return "white"; }
    }

    foreach($lines as $key => $line) {   
        $trimmedLine = trim($line);
        $noSpaces = str_replace(' ', '', $trimmedLine);
        $lines[$key] = $noSpaces;
        if(preg_match('/[X|O]/', $noSpaces)) {
            $emptyBoard = false;
        }
    }
    
    if($emptyBoard) { return '';}

    return (!playGame($lines, 'X')) ? 
        playGame(rotateBoard($lines), 'O') : "black";
}

function playGame($lines, $player) {
    $trace = [];
    foreach($lines as $key => $line) {   
        if (str_starts_with($line, $player)) {
            $trace[] = [[$key, 0]];  
        }
    }
    return trace($lines, $trace, $player);
}

function rotateBoard($lines) : array {
    $rotated = [];
    for($i=0, $end=strlen($lines[0]); $i < $end; $i++) {
        $newLine = '';
        foreach($lines as $line) {
            $newLine .= $line[$i];
        }
        $rotated[] = $newLine;
    }
    return $rotated;
}

function trace($game, $traces, $player) : string {
    foreach($traces as $trace)  {
        $result = followTrace($player, $game, $trace); 
        if($result === "black" || $result === "white") { return $result; }
    }
    return "";
}

function checkBoardBoundaries($game, $line, $position) : bool {
    if($line >= count($game) || $line < 0) { return false; }
    elseif($position >= strlen($game[0]) || $position < 0) { return false;}
    return true; 
}

function lookForNextTrace($game, $coordinates, $trace, $player) : array {
    if(!checkBoardBoundaries($game, $coordinates[0], $coordinates[1]) ) { 
        return $trace;
    }
    if($game[$coordinates[0]][$coordinates[1]] === $player 
        && array_search($coordinates, $trace) === false) {
            $trace[] = $coordinates;
    }
    return $trace;
}

function followTrace($player, $game, $trace) : string {

    //the position of the last X or O in the trace array has not yet reached the other end of the board
    // which is the length of the string minus 1
    while(end($trace)[1] !== strlen($game[0])-1) {

        $tail = end($trace);
        $tailLine = $tail[0];
        $tailPos = $tail[1];
     
        $countTrace = count($trace);

        $trace = lookForNextTrace($game, [$tailLine, $tailPos+1], $trace, $player);
        $trace = lookForNextTrace($game, [$tailLine, $tailPos-1], $trace, $player);
        $trace = lookForNextTrace($game, [$tailLine+1, $tailPos], $trace, $player);
        $trace = lookForNextTrace($game, [$tailLine-1, $tailPos], $trace, $player);
        $trace = lookForNextTrace($game, [$tailLine-1, $tailPos+1], $trace, $player);
        $trace = lookForNextTrace($game, [$tailLine+1, $tailPos-1], $trace, $player);

        // nothing has been added, so we've reached a dead end
        if(count($trace) === $countTrace) { 
            return "";
        } 
    }
    return ($player === 'X') ? "black" : "white";   
}
