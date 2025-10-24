//
// This is only a SKELETON file for the 'Wordy' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const answer = (question) => {
  const integrity = questionIntegrity(question);
  if(integrity === "number") { 
    return Number(question.match(/\-*\d+/));
  } 
  else if(integrity === 'Syntax error') {
    throw new Error('Syntax error');
  }
  else if(integrity === 'Unknown operation') {
    throw new Error('Unknown operation');
  }
  let calculation = 0;
  question = question.slice("What is ".length);
  while(question.length > 0 ) {
    const calcRegex = /(\-*\d*\s*minus \-*\d*)|(\-*\d*\s*plus \-*\d+)|(\-*\d*\s*multiplied by \-*\d+)|(\-*\d*\s*divided by \-*\d+)/
    try {
      const result = question.match(calcRegex)[0];
      const splitRes = result.split(' ')
      const operator = result.match(/plus|minus|multiplied by|divided by/);
      calculation = (calculation === 0) ? 
        math_it_up[operator](Number(splitRes[0]), Number(splitRes[splitRes.length-1])) : 
        math_it_up[operator](calculation, Number(splitRes[splitRes.length-1])); 
      question = question.slice(result.length+1);
    }
    catch(error) {
      console.log(error)
    }
  }
  return calculation
}

const questionIntegrity = (question) => {

  if(/^What is \-*\d+\?$/.test(question)) { return "number" } 
  
  const consecutiveOperators = /((plus|minus|divided by|multiplied by)\s){2,}/;
  const consecutiveNumbers = /(\d+[\s\?]){2,}/;
  const correctOperator = /(What is\s\-*\d+\s(plus|minus|divided by|multiplied by)+\s\-*\d+[\s\?]+)/;
  const missingNumber = /(What is\s\d+\s(plus|minus|divided by|multiplied by)+\?)/

  if(question === "What is?" 
    ||question.match(consecutiveOperators) 
    || question.match(consecutiveNumbers) 
    || question.match(missingNumber)) {
    return "Syntax error"
  }
  if(!/What is/.test(question) || !question.match(correctOperator)) {
    return 'Unknown operation';
  }
}

// https://stackoverflow.com/questions/13077923/how-can-i-convert-a-string-into-a-math-operator-in-javascript
const math_it_up = {
  'plus': function (x, y) { return x + y },
  'minus': function (x, y) { return x - y },
  'multiplied by': function (x, y) { return x * y },
  'divided by': function (x, y) { return x / y }
}
