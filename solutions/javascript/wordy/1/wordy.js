//
// This is only a SKELETON file for the 'Wordy' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const answer = (question) => {
  if(question.length <= 8) {
    throw new Error('Syntax error')
  }
  if(/What is/.test(question)) {
    let elements = question.slice(8, -1).split(' ')
    if(elements.length === 1 && /^\-*\d+/.test(elements[0])) {
      return Number(elements[0]);
    }
    elements = elements.filter(el => el != 'by');
    if(!checkQuestionIntegrity(elements)) { 
      throw new Error('Syntax error');
      return;
    } 
    else {
      let calculation = 0;
      while(elements.length > 0 ) {
        let { index, operator } = findOperator(elements);
        if(operator === null) { 
            console.log(operator + " operator is null")
            console.log(elements)
            throw new Error('Unknown operation');
        }
        let calculator = (index > 0 ) ? Number(elements[index-1]) : calculation;
        if(!elements[index+1]) { 
          throw new Error('Syntax error');
        }
        calculation = math_it_up[operator](calculator, Number(elements[index+1]));
        (index > 0) ? elements.splice(index-1, 3) : elements.splice(index, 2) 
      }
      return calculation
    }
  }
  else {
    throw new Error('Unknown operation');
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

const checkQuestionIntegrity = (elements) => {
  const operators = ['plus', 'minus', 'divided', 'multiplied'];
  let operator = (operators.indexOf(elements[0]) >= 0) ? 'even' : 'odd';
  for(let i = 0, lengte = elements.length; i < lengte; i++) {
    const operatorIndex = operators.indexOf(elements[i]);
    if(operatorIndex < 0 && !Number(elements[i])) {
      return "true";
    }
    if(operator === 'even') {
      if(i % 2 === 0 && operatorIndex >= 0) { 
        return false;
      }
    } else {
      if(i % 2 != 0 && operatorIndex < 0) { 
        return false;
      }
    }
  }
  return true;
}

// https://stackoverflow.com/questions/13077923/how-can-i-convert-a-string-into-a-math-operator-in-javascript
const math_it_up = {
  'plus': function (x, y) { return x + y },
  'minus': function (x, y) { return x - y },
  'multiplied': function (x, y) { return x * y },
  'divided': function (x, y) { return x / y }
}
