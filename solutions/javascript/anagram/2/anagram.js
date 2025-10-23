//
// This is only a SKELETON file for the 'Anagram' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const findAnagrams = (word, anagrams) => {
  word = word.toLowerCase();
  const letters = word.split('').sort();
  const results = [];
  anagrams.forEach(anagram => {
    const lowerAnagram = anagram.toLowerCase();
    if(word === lowerAnagram){ return; }
    const anaLetters = lowerAnagram.split('').sort();
    if(letters.join('') === anaLetters.join('')) {
      results.push(anagram);
    }    
  })
  return results;
};
