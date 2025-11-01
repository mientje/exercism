//
// This is only a SKELETON file for the 'Triangle' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class Triangle {
  constructor(...sides) {
    [this.side1, this.side2, this.side3] = sides;    
    this._isTriangle = this.triangleIntegrity();    
  }

  triangleIntegrity() {
    if(this.side1 === 0 && this.side2 === 0 && this.side3 === 0) { return false }
    if(this.side1 + this.side2 < this.side3) { return false }
    else if(this.side2 + this.side3 < this.side1) { return false }
    else if(this.side1 + this.side3 < this.side2) { return false }
    return true;
  }

  get isEquilateral() {
    if(!this._isTriangle) { return false }
    return this.side1 === this.side2 && this.side2 === this.side3;
  }

  get isIsosceles() {
    if(!this._isTriangle) { return false }
    return this.side1 === this.side2 || this.side1 === this.side3 || this.side2 === this.side3;
  }
 
  get isScalene() {
    if(!this._isTriangle) { return false }
    return !this.isEquilateral && !this.isIsosceles;
  }

}

