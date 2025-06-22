//
// This is only a SKELETON file for the 'Raindrops' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const convert = (drop) => {
  let answer = "";
  if(drop % 3 === 0) { 
    answer += 'Pling'
  }
  if(drop % 5 === 0) { 
    answer += 'Plang'
  }
  if(drop % 7 === 0) { 
    answer +='Plong'
  }
  return (answer === "") ? drop.toString() : answer;  
};
