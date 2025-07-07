<?php

declare(strict_types=1);

class Game
{
    private const MAX_FRAMES = 10;
    private const BONUS_FRAME = 11;
    private const SECOND_BONUS_FRAME = 12;
    private const MAX_POINTS = 10;
    private const STRIKE = 10;
    private const SPARE = 10;
    private array $frames = [];
    private string $rolls = "firstThrow";
    private int $curFrame = 0;

 
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

            // strike
            if($currentFirst === self::STRIKE) {
                $total += self::STRIKE + $nextFirst; 
                $total += ($nextFirst === self::STRIKE) ? $nextNextFirst : $nextSecond;
                // every tenth frame a strike gets two bonus fills 
                if ($index === self::MAX_FRAMES-1)  { break; }
            }

            // spare: both throws add up two ten
            elseif($currentFirst + $currentSecond === self::SPARE) {  
                $total += ($index === self::MAX_FRAMES-1) ? self::STRIKE : self::STRIKE + $nextFirst;
            }
            // no strike and no spare : both throws add up to less than ten
            else {        
                $total+= $currentFirst + $currentSecond;
            }            
        }
        echo "total: " . $total .  "\n";
        return $total;
    }

    public function roll(int $pins): void
    {
        $this->validateRoll($pins);
        if($this->rolls === "firstThrow") {
            if ($pins === self::STRIKE) {
                $this->frames[] = [self::STRIKE, 0];
                $this->curFrame++;
            } else {
                $this->frames[] = [$pins];
                $this->rolls = "secondThrow";
            }
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
    /**
     * @throws \Exception
     */
    private function validateScore()  {
        $numOfFrames = count($this->frames);
        $tenthFrame = $this->frames[self::MAX_FRAMES-1];
        
        if(!$this->frames) {
            throw new Exception("There have been no throws yet.");
        }
        // game not yet finished
        if($numOfFrames < self::MAX_FRAMES) {
            throw new Exception("At least 20 throws are required");
        }
        if($numOfFrames === self::MAX_FRAMES) {
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
        if($numOfFrames === self::BONUS_FRAME 
            && $tenthFrame[0] === self::STRIKE 
            && $this->frames[self::BONUS_FRAME-1][0] === self::STRIKE) {
            throw new Exception("One more bonus roll for a strike in the last frame must be rolled before the score can be calculated");
        }
    }
    /**
     * @throws \Exception
     */
    private function validateRoll(int $pins) : void{
        $countFrames = count($this->frames);
        $curFrame = $this->frames[$countFrames-1];
        $tenthFrame = $this->frames[self::MAX_FRAMES-1];
        $BONUS_FRAME = $this->frames[self::BONUS_FRAME-1];

        if($pins < 0) {
            throw new invalidArgumentException ("A roll cannot score negative points.");
        }
        if($pins > self::STRIKE ) {
            throw new InvalidArgumentException("A roll cannot score more than 10 points.");
        }
        // second throw has not yet been added to the array     
        if(!is_int($curFrame[1]) 
            && $curFrame[0] + $pins > self::MAX_POINTS) {
            throw new InvalidArgumentException("Two rolls in a frame cannot score more than ten points.");
        }
        if($countFrames === self::SECOND_BONUS_FRAME) {
            throw new Exception("You cannot continue. Two fillballs have been thrown. The game is so finished.");
        } 
        if(($countFrames === self::BONUS_FRAME 
            && $tenthFrame[0] !== self::STRIKE 
            && $tenthFrame[0] + $tenthFrame[1] === self::SPARE)) {
            throw new Exception("A fillball has been thrown. You cannot continue. The game is already finished.");
        }
        if($countFrames === self::MAX_FRAMES && count($tenthFrame) === 2
            && $tenthFrame[0] + $tenthFrame[1] !== self::SPARE) {
            throw new Exception("You cannot continue. The game is already finished.");

        }
        // strike in tenth frame + two fill balls have already been thrown
        if(is_int($BONUS_FRAME[1])
            && $BONUS_FRAME[0] + $BONUS_FRAME[1] < self::SPARE) {
            throw new Exception("You cannot roll after two bonus rolls for a strike.");
        }
    }
}

        

          