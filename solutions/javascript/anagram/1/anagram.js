//
// This is only a SKELETON file for the 'Anagram' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const findAnagrams = (word, anagrams) => {
  word = word.toLowerCase();
  const letters = word.split('').sort();
  const wordLength = word.length;
  const anagramLength = anagrams.length;
  const results = [];
  for(let i = 0; i < anagramLength; i++) {
    const anagram = anagrams[i].toLowerCase();
    if(wordLength === anagram.length && word !== anagram) {
      const anaLetters = anagram.split('').sort();
      if(letters.join('') === anaLetters.join('')) {
        results.push(anagrams[i]);
      }
    }
  }
  return results;
};
