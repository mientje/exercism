//
// This is only a SKELETON file for the 'Pangram' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const isPangram = (sentence) => {
  if(sentence === "") { return false; }
  sentence = sentence.toLowerCase();
  const alphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
  for(let x = 0, lengte = alphabet.length; x < lengte; x++) {
    if(sentence.indexOf(alphabet[x]) < 0) {
      return false;
    }
  }
  return true;
};
