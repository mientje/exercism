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

    if(count($lines) === 1) {
        if ($lines[0] === "X") { return "black"; }
        elseif($lines[0] === "O") { return "white"; }
    }

    foreach($lines as $key => $line) {   
        $newLine = trim($line);
        $lines[$key] = $newLine;
        // find out if the board contains X or O at tall
        if(preg_match('/[X,O]/', $newLine)) {
            $emptyBoard = false;
        }
        // find the start for the trail of X pieces
        if (str_starts_with($newLine, 'X')) {
            $traceX[] = [[$key, 0]];        
        }
    }
    // the board contains no pieces
    if($emptyBoard) { return '';}
 
    // trace all the X's
    $gameX = trace($lines, $traceX, 'X');
    // X doesn't win so find out if O wins
    if($gameX === "") {
        // find start of trail of O pieces
        preg_match_all('/(O+[^O]*)/', $lines[0], $matches, PREG_OFFSET_CAPTURE);
        foreach($matches as $match) {
            $traceO[] = [[0, $match[0][1]]];        
        }
        $traceO = array_unique($traceO);      
        // if O wins white is returned or ''
        return trace($lines, $traceO, 'O');
    }
    // X has won
    return "black";

}

function trace($game, $traces, $player) : string{
    $start = 0;
    $endTrace = ($player === 'X') ? strlen($game[0])-1 : count($game)-1;
    $playerColor = ($player === 'X') ? "black" : "white";    
    // I use arrays with coordinates : line, position on the line
    // O moves from top to bottom, that's the first element in the array, the line
    // X moves from left to right, so that's the second element in the array, the position
    $playerCoord = ($player === 'X') ?  1 : 0;
    //  the array that contains pieces that form a trail to the solution
    $added = [];

    foreach($traces as $key => $trace)  {

        while(end($trace)[$playerCoord] !== $endTrace) {

            $tail = end($trace);
            $tailLine = $tail[0];
            $tailPos = $tail[1];
            // breaks me out of the while loop = if no pieces have been added, I break
            $addedPiece = false;
            //to the right of XorO
            if($game[$tailLine][$tailPos+2] === $player ) { 
                $added[] = [$tailLine, $tailPos+2];
            }
            //to the left of XorO and if the trace stopped 
            // on a position bigger than O
            if($game[$tailLine][$tailPos-2]  === $player 
                && $tailPos > 0 ) {
                $added[] = [$tailLine, $tailPos-2];
            }
            // beneath XorO and if the trace stopped on a 
            // line that's above the bottom line
            if($game[$tailLine+1][$tailPos]  === $player 
                && $tailLine < $endTrace) {
                $added[] = [$tailLine+1, $tailPos];
            }
            // above XorO an if the trace stopped on a line 
            // that's beneath the top line
            if($game[$tailLine-1][$tailPos]  === $player 
                && $tailLine > 0) {
                $added[] = [$tailLine-1, $tailPos];
            }
            //to the right above XorO and the trace stopped 
            // on a line beneath the top line
            if($game[$tailLine-1][$tailPos+2]  === $player 
                && $tailLine > 0) {
                $added[] = [$tailLine-1, $tailPos+2];
            }
            // to the left beneath XorO and the trace stopped 
            // on index 1 or bigger and the line is above the  last line.
            if($game[$tailLine+1][$tailPos-2]  === $player 
                && $tailPos >= 1 && $tailLine < $endTrace) {
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