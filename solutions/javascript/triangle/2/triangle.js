//
// This is only a SKELETON file for the 'Triangle' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class Triangle {
  constructor(...sides) {
    this.sides = [...sides];
    this._isTriangle = this.triangleIntegrity();
    this._isIsosceles = this.isosceles();
    this._isScalene = this.scalene();
  }

  triangleIntegrity() {
    const side1 = this.sides[0];
    const side2 = this.sides[1];
    const side3 = this.sides[2];
    if(side1 === 0 && side2 === 0 && side3 === 0) { return false }
    if(side1 + side2 < side3) { return false }
    else if(side2 + side3 < side1) { return false }
    else if(side1 + side3 < side2) { return false }
    return true;
  }

  get isEquilateral() {
    if(!this._isTriangle) { return false }
    return this.sides[0] === this.sides[1] && this.sides[1] === this.sides[2];
  }
  
  isosceles() {
    if(!this._isTriangle) { return false }
    return this.sides[0] === this.sides[1] || this.sides[0] === this.sides[2] || this.sides[1] === this.sides[2];
  }

  get isIsosceles() {
    return this._isIsosceles;
  }

  scalene() {
    if(!this._isTriangle) { return false }
    return !this._isEquilateral && !this._isIsosceles;
  }

  get isScalene() {
    return this._isScalene;
  }

}

