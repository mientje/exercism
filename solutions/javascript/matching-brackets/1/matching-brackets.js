//
// This is only a SKELETON file for the 'Matching Brackets' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const isPaired = (input) => {
  if(input.length === 0) { return true; }
  const regex = /[\w\\\/\+\*-\.\^\&\s]/g
  const matches = [...input.matchAll(regex)];
  const replaced = input.replace(regex, '');
  if(replaced.length % 2 > 0 ) { 
    return false; 
  }
  const brackets = { };
  brackets.open = [ '(', '[', '{' ]; 
  brackets.closed = [ ')', ']', '}' ];
  for(let i = 0, lengte = replaced.length; i < lengte / 2; i++) {                    
    const openingbracketindex = brackets.open.indexOf(replaced[i]);
    if(openingbracketindex >= 0) {
      const openingBracket = replaced[i];
      const closingBracket = brackets.closed[openingbracketindex];
      if(replaced[i+1] != closingBracket && replaced[lengte-1-i] != closingBracket) {           return false;
      }
      else if(i > replaced.indexOf(closingBracket)) { return false; }
      else { return true; }
    }
    return false;
  }
};