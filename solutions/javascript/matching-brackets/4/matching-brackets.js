//
// This is only a SKELETON file for the 'Matching Brackets' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const isPaired = (input) => {
  if(input.length === 0) { return true; }
  const replaced = input.replace(/[\w\\\/\+\*-\.\^\&\s]/g, '').split('');
  const brackets = [ [ '(', ')' ], [ '{', '}' ], [ '[', ']' ] ];
  if(replaced.length % 2 > 0 ) { return false; }
  while(replaced.length > 0) {
    // openIndex : index of the opening bracket in the brackets object
    // i : selected bracket in replaced
    const { openIndex, i } = findOpenIndex(brackets, replaced);
    if(openIndex < 0) { return false; }
    // index of the matching closing bracket
    const matchingIndex = findMatchingIndex(replaced, i , brackets[openIndex][1]);
    if(matchingIndex < 0 ) { return false}
    replaced.splice(i+matchingIndex, 1); // remove closing bracket
    replaced.splice(i, 1);  // remove matching opening bracket
  }
  return true; 
};

export const findMatchingIndex = (replaced, i, closingBracket, matchingIndex = 1) => {
  if(matchingIndex >= replaced.length) { return -1; } 
  if(replaced[i+matchingIndex] != closingBracket) {                 
    return findMatchingIndex(replaced, i, closingBracket, matchingIndex+2 );
  }
  return matchingIndex;
}

export const findOpenIndex = (brackets, replaced, i = (replaced.length/2)-1) => {
  if(i < 0) { return  { "openIndex" : -1, "i" : i }  }
  const openIndex = brackets.findIndex((type, index) => type[0] === replaced[i]);
  if(openIndex === -1) { 
    return (findOpenIndex(brackets, replaced, i-1))
  }
  return { "openIndex" : openIndex, "i" : i } ;                
}