//
// This is only a SKELETON file for the 'Conway's Game of Life' exercise. It's been provided
// as a convenience to get y$ou started writing code faster.
//

export class GameOfLife {
  constructor(matrix) {
	this.matrix = matrix;
	this.colLength = (matrix[0]) ? matrix[0].length : undefined;
	this.rowLength = (matrix[0]) ? matrix.length : undefined;
  }

  tick() {
	if(!this.matrix[0]) { return; }
	const newMatrix = [];
	for(let rowIndex = 0; rowIndex < this.rowLength; rowIndex++) {
		newMatrix.push([]);
		for(let colIndex = 0; colIndex < this.colLength; colIndex++) {	
			const cell = this.matrix[rowIndex][colIndex];			
  			const neighbours = this.findNeighbours(rowIndex, colIndex);
 			if(cell === 1 && (neighbours === 3 || neighbours === 2)) {
				newMatrix[rowIndex].push(1);
			}
			else if(cell === 0 && neighbours === 3) { 
				newMatrix[rowIndex].push(1);
			}
			else {
				newMatrix[rowIndex].push(0);
			}
		}
 	 }
 	 this.matrix = newMatrix;
 	 return this.matrix;
   }
  
  state() {
	return this.matrix;
  }

 findNeighbours(rowIndex, colIndex) {
	const above = (rowIndex > 0) ? true : false; 
	const below = (rowIndex < this.rowLength-1) ? true : false;
	const leftEdge = (colIndex === 0) ? true : false;
	const rightEdge = (colIndex === this.rowLength-1) ? true : false;
	let liveNeighbours = 0;

	if(!leftEdge) {
		if(this.matrix[rowIndex][colIndex-1] === 1) { liveNeighbours += 1 } //  LEFT
	}
	if(!rightEdge) {
		if(this.matrix[rowIndex][colIndex+1] === 1) { liveNeighbours += 1 } //  RIGHT
	}
	if(above) {
		if(this.matrix[rowIndex-1][colIndex] === 1) { liveNeighbours += 1 } // ABOVE
		if(!leftEdge) { 
			if(this.matrix[rowIndex-1][colIndex-1] === 1) { liveNeighbours += 1 } // UPPERLEFT
		}		
		if(!rightEdge) { 
			if(this.matrix[rowIndex-1][colIndex+1] === 1) { liveNeighbours += 1 } // UPPERRIGHT
		}
	}
	if(below) {
		if(this.matrix[rowIndex+1][colIndex] === 1) { liveNeighbours += 1 } // BELOW
		if(!leftEdge) { 
 			if(this.matrix[rowIndex+1][colIndex-1] === 1) { liveNeighbours += 1 } // LOWERLEFT
		}		
		if(!rightEdge) { 
 			if(this.matrix[rowIndex+1][colIndex+1] === 1) { liveNeighbours += 1 } // LOWERRIGHT
		}
	}
	return liveNeighbours;
  }
}
