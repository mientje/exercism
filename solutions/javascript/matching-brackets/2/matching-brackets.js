//
// This is only a SKELETON file for the 'Matching Brackets' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const isPaired = (input) => {
  if(input.length === 0) { return true; }
  let replaced = input.replace(/[\w\\\/\+\*-\.\^\&\s]/g, '').split('');
  if(replaced.length % 2 > 0 ) { return false; }
  const brackets = [ [ '(', ')' ], [ '{', '}' ], [ '[', ']' ] ];
  let matchingIndex = 1;
  while(replaced.length > 0) {
    const { openIndex, i } = findOpenIndex(brackets, replaced);
    if(openIndex < 0) { return false; }
    const matchingIndex = findMatchingIndex(replaced, i , brackets[openIndex][1]);
    if(matchingIndex < 0 ) { return false}
    replaced.splice(i+matchingIndex, 1);
    replaced.splice(i, 1);
  }
  return true; 
};

export const findMatchingIndex = (replaced, i, closingBracket, matchingIndex = 1) => {
  if(matchingIndex >= replaced.length) { return -1; } 
  if(replaced[i+matchingIndex] != closingBracket) {
    matchingIndex += 2;                   
    return findMatchingIndex(replaced, i, closingBracket, matchingIndex );
  }
  return matchingIndex;
}

export const findOpenIndex = (brackets, replaced, i = (replaced.length/2)-1) => {
  if(i < 0) { return  { "openIndex" : -1, "i" : i }  }
  const openIndex = brackets.findIndex((type, index) => type[0] === replaced[i]);
  if(openIndex === -1) { 
    i--;
    return (findOpenIndex(brackets, replaced, i))
  }
  return { "openIndex" : openIndex, "i" : i } ;                
}