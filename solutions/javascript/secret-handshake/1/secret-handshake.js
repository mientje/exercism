//
// This is only a SKELETON file for the 'Secret Handshake' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const commands = (num) => {
  return num.toString(2).split('').reverse().reduce((acc, curdigit, index) => {
    if(curdigit === "1") {
      switch(index % 5) {
        case 0: 
          acc.push("wink");
          return acc;
        case 1: 
          acc.push("double blink");
          return acc;
        case 2: 
          acc.push("close your eyes")
          return acc;
        case 3: 
          acc.push("jump")
          return acc;
        case 4: 
          acc = acc.reverse(); 
          return acc; 
      }
    }
    return acc; 
  }, [])
};