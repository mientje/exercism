//
// This is only a SKELETON file for the 'Clock' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class Clock {
  constructor(hours=0, minutes=0) {
    this.hours = hours;
    this.minutes = minutes;
  }

  calculateTime(comp, divider) {
    if(comp < 0) { 
      comp = divider + (comp % divider);
    }
    comp %= divider;
    return comp;
  }

  toString() {
    this.hours += Math.floor(this.minutes/60);    
    this.hours = this.calculateTime(this.hours, 24); 
    this.minutes = this.calculateTime(this.minutes, 60).toString(); 
    return this.hours.toString().padStart(2, "0") + ':' + this.minutes.toString().padStart(2, "0");
  }

  plus(minutes) {
    this.minutes += minutes;
    return this.toString();
  }

  minus(minutes) {
    this.minutes -= minutes;
    return this.toString();  }

  equals(clock) {
    return this.toString() === clock.toString()
  }
}
  

