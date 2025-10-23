//
// This is only a SKELETON file for the 'Anagram' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const findAnagrams = (word, anagrams) => {
  word = word.toLowerCase();
  const letters = word.split('').sort().join('');
  const results = new Set();
  anagrams.forEach(anagram => {
    const lowerAnagram = anagram.toLowerCase();
    if(word === lowerAnagram) { return; }
    const anaLetters = lowerAnagram.split('').sort().join('');
    if(letters === anaLetters) { results.add(anagram); }
  }) 
  return Array.from(results)
};
