<?php

declare(strict_types=1);

class Game
{

    private const MAX_THROWS = 20;
    private const FILL_BALLS = 2;
    private const MAX_POINTS = 10;
    private array $thrown = [];
    
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
            if($firstThrow === self::MAX_POINTS) {
                $total += self::MAX_POINTS + $thirdThrow;   
                $total+= ($thirdThrow === self::MAX_POINTS)  ? $fifthThrow : $fourthThrow;
                // strike in 10th frame: bonus balls added to 10th frame and then it's finished
                if ($i === self::MAX_THROWS-2)  { break; }
            }
            // Spare : both throws add up two ten
            elseif($firstThrow + $secondThrow === self::MAX_POINTS) {  
                $total += self::MAX_POINTS + $thirdThrow;
                // spare in 10th frame:bonus ball added to 10th frame and then it's finished
                if ($i === self::MAX_THROWS-2)  { break; }
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
        if($pins === self::MAX_POINTS) { $this->thrown[] = 0; }  
    }

    private function validateScore() : void {

        $rollsThrown = count($this->thrown);
        $firstLastThrow = $this->thrown[self::MAX_THROWS-2];
        $secondLastThrow = $this->thrown[self::MAX_THROWS-1];
 
        echo "rolls thrown " . $rollsThrown . "\n";

        if($rollsThrown === 0) {
            throw new Exception("There have been no throws yet.");
        }
        // game not yet finished
        if($rollsThrown < self::MAX_THROWS) {
            throw new Exception("At least 20 throws are required");
        }
        // tenth frame
        if($rollsThrown === self::MAX_THROWS) {
            // strike in tenth frame - two more bonus rolls
            if($firstLastThrow === self::MAX_POINTS) {
                throw new Exception("Two bonus rolls for a strike in the last frame must be rolled before the score can be calculated");
            }
            // spare in tenth frame - one more bonus roll
            else {
                if($firstLastThrow  + $secondLastThrow  === self::MAX_POINTS) {
                    throw new Exception("A bonus roll for a spare in the last frame must be rolled before the score can be calculated");
                }
            }
        }
        //FILL_BALLS
        // strike in tenth frame + first fillball is not a strike, one more must be thrown
        if($rollsThrown === self::MAX_THROWS+1
            && $firstLastThrow === self::MAX_POINTS 
            && $this->thrown[self::MAX_THROWS] < self::MAX_POINTS ) {
            throw new Exception("One more bonus roll for a spare in the last frame must be rolled before the score can be calculated");
        }
        // strike in tenth frame + first fillball is 2nd strike, so 10 and zero are added, next fillball must be thrown 
        if($rollsThrown === self::MAX_THROWS+2 
            && $this->thrown[self::MAX_THROWS] === self::MAX_POINTS) {
                throw new Exception("The bonus roll was a strike. One more bonus roll must be rolled before the score can be calculated");
        }         
    }

    private function validateRoll(int $pins) : void {
    
        $rollsThrown = count($this->thrown);
        $firstLastThrow = $this->thrown[self::MAX_THROWS-2];
        $secondLastThrow = $this->thrown[self::MAX_THROWS-1];
     
        if($pins < 0) {
            throw new invalidArgumentException ("A roll cannot score negative points.");
        }
        if($pins > self::MAX_POINTS ) {
            throw new InvalidArgumentException("A roll cannot score more than 10 points.");
        }
        if(($rollsThrown % 2 !== 0) && $this->thrown[$rollsThrown-1] + $pins > self::MAX_POINTS) {
            throw new InvalidArgumentException("Two rolls in a frame cannot score more than ten points.");
        }
        //tenth frame - no strike or spare was thrown
        if($rollsThrown === self::MAX_THROWS && $firstLastThrow + $secondLastThrow !== self::MAX_POINTS) {
            throw new Exception("You cannot continue. The game is already finished.");
        }
        // first fillball - a spare in the tenth frame was thrown
        if ($rollsThrown === self::MAX_THROWS + self::FILL_BALLS -1 
            && $firstLastThrow !== self::MAX_POINTS 
            && $firstLastThrow + $secondLastThrow === self::MAX_POINTS) {
            throw new Exception("You cannot roll after twenty rolls + a bonus roll for a strike.");
        }
        //second fillball - a strike in the tenth frame was thrown
        if($rollsThrown === self::MAX_THROWS + self::FILL_BALLS  
            && $this->thrown[self::MAX_THROWS] + $this->thrown[self::MAX_THROWS+1] < self::MAX_POINTS) {
            throw new Exception("You cannot roll after two bonus rolls for a strike.");
        }
    }
}
 