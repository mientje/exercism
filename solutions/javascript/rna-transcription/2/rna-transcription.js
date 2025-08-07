//
// This is only a SKELETON file for the 'RNA Transcription' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const toRna = (sequence) => {
  let result = "";
  for(let x = 0, lengte = sequence.length; x < lengte; x++) {
    switch(sequence[x]) {
      case '': 
        return sequence;
      case 'C':
        result += 'G';
        break;
      case 'G':
        result += 'C';
        break;
      case 'T':
        result += 'A';
        break;
      case 'A' : 
        result += 'U';
    }
  }
  return result;
};
