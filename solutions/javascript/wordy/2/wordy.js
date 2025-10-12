//
// This is only a SKELETON file for the 'Wordy' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const answer = (question) => {
  let integrity = questionIntegrity(question);
  if(integrity === 'Syntax error') {
    throw new Error('Syntax error');
  }
  else if(integrity === 'Unknown operation') {
    throw new Error('Unknown operation');
  }
  else if(Number(integrity)) { 
    return integrity 
  } 
  else {
    let calculation = 0;
    while(integrity.length > 0 ) {
      let { index, operator } = findOperator(integrity);
      let calculator = (index > 0 ) ? Number(integrity[index-1]) : calculation;
      calculation = math_it_up[operator](calculator, Number(integrity[index+1]));
      (index > 0) ? integrity.splice(index-1, 3) : integrity.splice(index, 2) 
    }
    return calculation
  }
}

const findOperator = (elements) => {
  const operators = ['plus', 'minus', 'divided', 'multiplied'];
  let index = elements.length-1;
  let operator = null;
  for(let i = 0, lengte = operators.length; i < lengte; i++) {
    const indexOf = elements.indexOf(operators[i]);
    if(index >= indexOf && indexOf >=0) {
      index = indexOf;
      operator = operators[i];
    }
  }
  return { 'index' : index, 'operator' : operator }  
}

const questionIntegrity = (question) => {
  if(question === "What is?") { return 'Syntax error'}
  else if(/What is/.test(question)) {
    let elements = question
      .slice(8, -1)
      .split(' ')
      .filter(el => el != 'by');
    if(elements.length === 1 && /^\-*\d+/.test(elements[0])) {
      return Number(elements[0]);
    } 
    const operators = ['plus', 'minus', 'divided', 'multiplied'];
    let operator = (operators.indexOf(elements[0]) >= 0) ? 'even' : 'odd';
    for(let i = 0, lengte = elements.length; i < lengte; i++) {
      const operatorIndex = operators.indexOf(elements[i]);
      if(i === lengte -1 && operators.indexOf(elements[i]) >= 0) {
        return "Syntax error"
      }      
      if(operatorIndex < 0 && !Number(elements[i]) && elements[i] !== "0") {
        return "Unknown operation";
      }
      if(operator === 'even') {
        if(i % 2 === 0 && operatorIndex >= 0) { 
          return "Syntax error";
        }
      } else {
        if(i % 2 != 0 && operatorIndex < 0) { 
          return "Syntax error";
        }
      }
    }
    return elements;
  }
  return 'Unknown operation'
}

// https://stackoverflow.com/questions/13077923/how-can-i-convert-a-string-into-a-math-operator-in-javascript
const math_it_up = {
  'plus': function (x, y) { return x + y },
  'minus': function (x, y) { return x - y },
  'multiplied': function (x, y) { return x * y },
  'divided': function (x, y) { return x / y }
}
