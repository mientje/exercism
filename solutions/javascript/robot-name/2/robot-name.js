// This is only a SKELETON file for the 'Robot Name' exercise. It's been
// provided as a convenience to get your started writing code faster.

export class Robot {
    
    constructor() {
        this._name = this.createName();
    }
    static releaseNames = () => {
        return this._name;
    };
    createName = function() {
        let robotName = '';
        const A = 65;
        const Z = 90;
        robotName += this.getRandomLetter(A, Z); 
        robotName += this.getRandomLetter(A, Z);
        robotName += this.getRandomNumber(0, 999);
        if (this.usedNames.has(robotName)) {
          return this.createName();        
        } else {
          this.usedNames.add(robotName);
          return robotName;
        }  
    }
    get name() {
        return this._name;
    }
    reset = function() {
        this._name = this.createName();
        return this._name;
    }
    getRandomNumber = function (min, max) {
        const randomNum = Math.ceil(Math.random() * (max - min) + min);
        return randomNum.toString().padStart(3, "0");
    }
    getRandomLetter = function(min, max) {
        return String.fromCharCode(this.getRandomNumber(min, max))
    }  

}

Robot.prototype.usedNames = new Set();