<?php

declare(strict_types=1);

class Game
{

    private const MAXFRAMES = 10;
    private const BONUSFRAME = 11;
    private const SECONDBONUSFRAME = 12;
    private const MAXPOINTS = 10;
    private const STRIKE = 10;
    private const SPARE = 10;
    
    function __construct() {
        $this->frames = [  ];
        $this->rolls = "firstThrow";
        $this->curFrame = 0;
    }

    public function score(): int
    {
        $this->validateScore();

        $total = 0;
        $index = 0;

        foreach($this->frames as $index => $throws) {
            $currentFirst = $throws[0];
            $currentSecond = $throws[1];
            $nextFirst = $this->frames[$index+1][0];
            $nextSecond = $this->frames[$index+1][1];
            // throw after two strikes in a row
            $nextNextFirst = $this->frames[$index+2][0];

            // strikes
            if($currentFirst === self::STRIKE) {
                $total += self::STRIKE + $nextFirst; 
                $total += ($nextFirst === self::STRIKE) ? $nextNextFirst : $nextSecond;
                // every tenth frame a strike gets two bonus fills 
                if ($index === self::MAXFRAMES-1)  { break; }
            }
            // both throws add up two ten
            elseif($currentFirst + $currentSecond === self::SPARE) {  
                $total += ($index === self::MAXFRAMES-1) ? self::STRIKE : self::STRIKE + $nextFirst;
            }
            // both throws add up to less than ten
            else {        
                $total+= $currentFirst + $currentSecond;
            }            
        }
        echo "total: " . $total .  "\n";
        return $total;
    }
    
    public function roll(int $pins): void
    {
        if($this->validateRoll($pins)) {
            if($this->rolls === "firstThrow") {
                if ($pins === self::STRIKE) {
                    $this->frames[] = [self::STRIKE, 0];
                    $this->curFrame++;
                } else {
                    $this->frames[] = [$pins];
                    $this->rolls = "secondThrow";
                }
                return;
            }
            else {
                if($pins === self::STRIKE) {
                    $this->frames[$this->curFrame] = [self::STRIKE, 0];
                } else {
                    $this->frames[$this->curFrame][] = $pins;
                }
                $this->curFrame++;
                $this->rolls = "firstThrow";
            }
        }
        else {
            $this->frames = false;
        }
    }

    private function validateScore() {

        $numOfFrames = count($this->frames);
        $tenthFrame = $this->frames[self::MAXFRAMES-1];

        if(!$this->frames) {
            throw new Exception("There have been no throws yet.");
        }
        // validateRoll returns false
        elseif($this->frames === false) {
            return false;
        }
        // game not yet finished
        elseif($numOfFrames < self::MAXFRAMES) {
            throw new Exception("At least 20 throws are required");
        }
        elseif($numOfFrames === self::MAXFRAMES) {
            // strike in tenth frame - two more bonus rolls
            if($tenthFrame[0] === self::STRIKE) {
                throw new Exception("Two bonus rolls for a strike in the last frame must be rolled before the score can be calculated");
            }
            // spare in tenth frame - one more bonus roll
            else {
                if($tenthFrame[0] + $tenthFrame[1] === self::SPARE) {
                    throw new Exception("A bonus roll for a spare in the last frame must be rolled before the score can be calculated");
                }
            }
        }
        // strike in tenth frame + second strike in a bonus roll
        elseif($numOfFrames === self::BONUSFRAME && $tenthFrame[0] === self::STRIKE && $this->frames[self::BONUSFRAME-1][0] === self::STRIKE) {
            throw new Exception("One more bonus roll for a strike in the last frame must be rolled before the score can be calculated");
        }
    }

    private function validateRoll(int $pins) {
    
        $countFrames = count($this->frames);
        $curFrame = $this->frames[$countFrames-1];
        $tenthFrame = $this->frames[self::MAXFRAMES-1];
        $bonusFrame = $this->frames[self::BONUSFRAME-1];
 
        if($pins < 0) {
            throw new invalidArgumentException ("A roll cannot score negative points.");
        }
        elseif($pins > self::STRIKE ) {
            throw new InvalidArgumentException("A roll cannot score more than 10 points.");
        }
        // for some reason count($frame) produces a error message stating that it's not an array
        // second throw has not yet been added to the array     
        if(!is_int($curFrame[1]) && $curFrame[0] + $pins > self::MAXPOINTS) {
            throw new InvalidArgumentException("Two rolls in a frame cannot score more than ten points.");
        }
        if($countFrames === self::SECONDBONUSFRAME) {
            throw new Exception("You cannot continue. Two fillballs have been thrown. The game is so finished.");
        } 
        elseif(($countFrames === self::BONUSFRAME && $tenthFrame[0] !== self::STRIKE && $tenthFrame[0] + $tenthFrame[1] === self::SPARE)) {
            throw new Exception("A fillball has been thrown. You cannot continue. The game is already finished.");
        }
        elseif($countFrames === self::MAXFRAMES && count($tenthFrame) === 2) {
            if($tenthFrame[0] + $tenthFrame[1] !== self::SPARE) {
                throw new Exception("You cannot continue. The game is already finished.");
            }
        }
        // strike in tenth frame + two fill balls have already been thrown
        elseif(is_int($bonusFrame[1]) && $bonusFrame[0] + $bonusFrame[1] < self::SPARE) {
            throw new Exception("You cannot roll after two bonus rolls for a strike.");
        }
        return 1;
    }

}
