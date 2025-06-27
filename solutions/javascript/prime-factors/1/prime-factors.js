//
// This is only a SKELETON file for the 'Prime Factors' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const primeFactors = (number) => {
  let divider = 2;
  const factors = [];
  if(number < divider) { return [ ] }  
  while (number >= divider) {
    if(number % divider === 0) {
      number = number / divider;    
      factors.push(divider);
    }
    else {
      divider ++;
    }
  }
  return factors;
}
