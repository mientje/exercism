//
// This is only a SKELETON file for the 'Pangram' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const isPangram = (sentence) => {
  if(sentence === "") { return false; }
  sentence = sentence.toLowerCase();
  sentence = sentence.replace(/[\s\d"'_,.]/g, "");
  const alfabet = new Set();
  sentence.split('').forEach(letter => alfabet.add(letter));
  return (alfabet.size === 26) ? true : false;
}
