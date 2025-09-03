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
    $traceX = [];
    $traceO = [];

    if(count($lines) === 1 && $lines[0] === "X") {
        return "black";
    }
    elseif(count($lines) === 1 && $lines[0] === "O") {
        return "white";
    }

    foreach($lines as $key => $line) {   
        $newLine = preg_replace('/^\s*/', '', $line);
        $lines[$key] = $newLine;
    }

    foreach($lines as $key => $line) {   
        preg_match_all('/[X,O]/', $line, $XOmatches, PREG_OFFSET_CAPTURE);
        if(count($XOmatches) > 0) {
            $emptyBoard = false;
        }
        if($line[0] === 'X') {
            $traceX[] = [[$key, 0]];        
        }
    }

    if($emptyBoard === true) { return '';}
 
    $gameX = trace($lines, $traceX, 'X');
    if($gameX === "") {
        preg_match_all('/(O+[^O]*)/', $lines[0], $matches, PREG_OFFSET_CAPTURE);
        foreach($matches as $match) {
            $traceO[] = [[0, $match[0][1]]];        
        }
        $traceO = array_unique($traceO);      
        return trace($lines, $traceO, 'O');
    }
    return "black";

}

function trace($game, $traces, $player) {
    $start = 0;
    $endTrace = ($player === 'X') ? strlen($game[0])-1 : count($game)-1;
    $playerColor = ($player === 'X') ? "black" : "white";    
    $playerCoord = ($player === 'X') ?  1 : 0;
    $added = [];

    foreach($traces as $key => $trace) {

        while(end($trace)[$playerCoord] !== $endTrace) {

            $tail = end($trace);
            $tailLine = $tail[0];
            $tailPos = $tail[1];
            $addedPiece = false;

            if($game[$tailLine][$tailPos+2] === $player ) { 
                $added[] = [$tailLine, $tailPos+2];
            }
            if($game[$tailLine][$tailPos-2]  === $player && $tailPos > 0 ) {
                $added[] = [$tailLine, $tailPos-2];
            }
            if($game[$tailLine+1][$tailPos]  === $player && $tailLine < $endTrace) {
                $added[] = [$tailLine+1, $tailPos];
            }
            if($game[$tailLine-1][$tailPos]  === $player && $tailLine > 0) {
                $added[] = [$tailLine-1, $tailPos];
            }
            if($game[$tailLine-1][$tailPos+2]  === $player && $tailLine > 0) {
                $added[] = [$tailLine-1, $tailPos+2];
            }
            if($game[$tailLine+1][$tailPos-2]  === $player && $tailPos >= 1 && $tailLine < $endTrace) {
                $added[] = [$tailLine+1, $tailPos-2];
            }
            if(count($added) > 0) {
                foreach($added as $add) {
                    if(array_search($add, $trace) === false) {
                        $trace[] = $add;
                        $addedPiece = true;
                    }
                }
                $traces[$key] = $trace;   
                if($addedPiece === false) { 
                    break;
                }
                $addedPiece = false;
            } 
            else { break ;}
            if(end($trace)[$playerCoord] === $endTrace) {   
                return  $playerColor;
            }
        }
    }
    return "";
}