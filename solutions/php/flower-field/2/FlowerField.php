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

class FlowerField
{
	
	public function __construct(array $garden)
   {
   	$this->garden = $garden;
   	$this->rowLength = (count($garden) > 0) ? strlen($garden[0]) : 0;
   	$this->numRows = count($garden);  
   	$this->surroundedby = 0;   	
   }
	
	public function emptyGarden() : bool {
		$emptyGarden = trim(implode($this->garden));		
		return (strlen($emptyGarden) === 0) ? true : false; 
	} 
	public function fullGarden() : bool {
		foreach($this->garden as $row) {
			if(strlen(preg_replace('/\s+/', '', $row)) !== $this->rowLength ) { return false; } 
		}
		return true;
	}
	
	public function isItAFlower($rowIndex, $position ) : int {
;		if($position > -1 && $this->garden[$rowIndex][$position] === "*") { 
			$this->surroundedby += 1; 	
		} 
		return $this->surroundedby;
	}
		 
	public function findFlowers($row, $flowerIndex) {
		$toTheRight = ($flowerIndex < $this->rowLength - 1) ? $flowerIndex+1 : -1;  
		$toTheLeft = ($flowerIndex > 0) ? $flowerIndex - 1 : -1;  

 		$this->isItAFlower($row, $flowerIndex);
 		$this->isItAFlower($row, $toTheRight);
 		$this->isItAFlower($row, $toTheLeft);
	} 
	 
   public function annotate(): array
	{
		if($this->emptyGarden() || $this->fullGarden() ) {
			return $this->garden;
		}
		else {
			$resultGarden = [];
			for($rowIndex = 0; $rowIndex < $this->numRows; $rowIndex++) {
				$row = str_split($this->garden[$rowIndex]);

 				for($flowerIndex = 0; $flowerIndex < $this->rowLength ; $flowerIndex++) {

					if($row[$flowerIndex] === ' ') {

						$above =  ($rowIndex > 0) ? $rowIndex - 1 : -1;  
 						$beneath = ($rowIndex < $this->numRows - 1) ? $rowIndex + 1 : -1; 

						$this->findFlowers($rowIndex, $flowerIndex);													
 						if($above > -1) { $this->findFlowers($above, $flowerIndex); };  
						if($beneath > -1) { $this->findFlowers($beneath, $flowerIndex); }

 						$row[$flowerIndex] = ($this->surroundedby === 0) ? ' ' : $this->surroundedby;   
 						$this->surroundedby = 0;
					}
				}
				$resultGarden[] = implode($row);
			}
	 		return $resultGarden;	
		}	
   }
}
