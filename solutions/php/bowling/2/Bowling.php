<?php

declare(strict_types=1);

class Game
{

    private const MAXTHROWS = 20;
    private const FILLBALLS = 2;
    private const MAXPOINTS = 10;
    
    function __construct() {
        $this->thrown = [  ];
    }

    public function score(): int
    {
        $this->validateScore();

        $total = 0;
        $lengte = count($this->thrown);

        for($i = 0; $i < $lengte; $i+=2) {
            $firstThrow = $this->thrown[$i];
            $secondThrow = $this->thrown[$i+1];
            $thirdThrow = $this->thrown[$i+2];
            $fourthThrow = $this->thrown[$i+3];
            $fifthThrow = $this->thrown[$i+4];

            // Strike
            if($firstThrow === self::MAXPOINTS) {
                $total += self::MAXPOINTS + $thirdThrow;   
                $total+= ($thirdThrow === self::MAXPOINTS)  ? $fifthThrow : $fourthThrow;
                // strike in 10th frame: bonus balls added to 10th frame and then it's finished
                if ($i === self::MAXTHROWS-2)  { break; }
            }
            // Spare : both throws add up two ten
            elseif($firstThrow + $secondThrow === self::MAXPOINTS) {  
                $total += self::MAXPOINTS + $thirdThrow;
                // spare in 10th frame:bonus ball added to 10th frame and then it's finished
                if ($i === self::MAXTHROWS-2)  { break; }
            }
            // No strike or spare : both throws add up to less than ten
            else {        
                $total+= $firstThrow + $secondThrow;
            }            
        }

        return $total;
    }
    
    public function roll(int $pins): void
    {
        $this->validateRoll($pins);
        $this->thrown[] = $pins;
        if($pins === self::MAXPOINTS) { $this->thrown[] = 0; }  
    }

    private function validateScore() {

        $rollsThrown = count($this->thrown);
        $firstLastThrow = $this->thrown[self::MAXTHROWS-2];
        $secondLastThrow = $this->thrown[self::MAXTHROWS-1];
 
        if($rollsThrown === 0) {
            throw new Exception("There have been no throws yet.");
        }
        // game not yet finished
        elseif($rollsThrown < self::MAXTHROWS) {
            throw new Exception("At least 20 throws are required");
        }
        // tenth frame
        elseif($rollsThrown === self::MAXTHROWS) {
            // strike in tenth frame - two more bonus rolls
            if($firstLastThrow === self::MAXPOINTS) {
                throw new Exception("Two bonus rolls for a MAXPOINTS in the last frame must be rolled before the score can be calculated");
            }
            // spare in tenth frame - one more bonus roll
            else {
                if($firstLastThrow  + $secondLastThrow  === self::MAXPOINTS) {
                    throw new Exception("A bonus roll for a MAXPOINTS in the last frame must be rolled before the score can be calculated");
                }
            }
        }
        //FILLBALLS
        // strike in tenth frame + first fillball is not a strike, one more must be thrown
        elseif($firstLastThrow === self::MAXPOINTS && $rollsThrown === self::MAXTHROWS + 1) {
            throw new Exception("One more bonus roll for a MAXPOINTS in the last frame must be rolled before the score can be calculated");
        }
        // strike in tenth frame + first fillball is 2nd strike, so 10 and zero are added, next fillball must be thrown 
        elseif($rollsThrown === self::MAXTHROWS + 2 && $this->thrown[$rollsThrown -2] === self::MAXPOINTS) {
            throw new Exception("The bonus roll was a MAXPOINTS. One more bonus roll must be rolled before the score can be calculated");
        }         
    }

    private function validateRoll(int $pins) {
    
        $rollsThrown = count($this->thrown);
        $firstLastThrow = $this->thrown[self::MAXTHROWS-2];
        $secondLastThrow = $this->thrown[self::MAXTHROWS-1];
     
        if($pins < 0) {
            throw new invalidArgumentException ("A roll cannot score negative points.");
        }
        elseif($pins > self::MAXPOINTS ) {
            throw new InvalidArgumentException("A roll cannot score more than 10 points.");
        }
        if(($rollsThrown % 2 !== 0) && $this->thrown[$rollsThrown-1] + $pins > self::MAXPOINTS) {
            throw new InvalidArgumentException("Two rolls in a frame cannot score more than ten points.");
        }
        //tenth frame - no strike or spare was thrown
        elseif($rollsThrown === 20 && $firstLastThrow + $secondLastThrow !== self::MAXPOINTS) {
            throw new Exception("You cannot continue. The game is already finished.");
        }
        // fillball one - a spare in the tenth frame was thrown
        elseif ($rollsThrown === 21 && $firstLastThrow !== self::MAXPOINTS && $firstLastThrow + $secondLastThrow === self::MAXPOINTS) {
            throw new Exception("You cannot roll after twenty rolls + a bonus roll for a strike.");
        }
        //fillball two - a strike in the tenth frame was thrown
        elseif($rollsThrown === 22 && $this->thrown[self::MAXTHROWS] + $this->thrown[self::MAXTHROWS+1] < self::MAXPOINTS) {
            throw new Exception("You cannot roll after two bonus rolls for a strike.");
        }
        return 1;
    }
}
 