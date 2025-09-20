// This is only a SKELETON file for the 'Robot Name' exercise. It's been
// provided as a convenience to get your started writing code faster.

export class Robot {
    
    constructor() {
        this.usedNames = new Set();
        this._name = this.createName();
    }
    static releaseNames = () => {
        return this._name;
    };
    createName = function() {
        let robotName = '';
        const A = 64;
        const Z = 91;
        robotName += this.getRandomLetter(A, Z); 
        robotName += this.getRandomLetter(A, Z);
        robotName += this.getRandomNumber(0, 1000);
        const usedNamesSize = this.usedNames.size;
        this.usedNames.add(robotName);
        return (usedNamesSize < this.usedNames.size) ?
            robotName : this.createName();
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