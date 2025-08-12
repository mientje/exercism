//
// This is only a SKELETON file for the 'Bob' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const hey = (message) => {
  const question = /[\w\d]*\?$/gm;
  const shout = /[A-Z]/gm;
  const digits = /\d+/g;
  const statement = /[a-z]+/g;

  message = message.trim();

  if(message.length === 0) {
    return "Fine. Be that way!";
  }
  if(message.match(question) != null) {
    if(statement.test(message) === false && shout.test(message) === true) {
      return "Calm down, I know what I'm doing!";
    } 
    return "Sure."
  }
  else if(digits.test(message)) {
    if(shout.test(message)) {
      return "Whoa, chill out!";
    }
    return "Whatever.";  
  }
  else if(statement.test(message)) {
      return "Whatever.";  
  } 
  else {
    return "Whoa, chill out!";
  }
}
