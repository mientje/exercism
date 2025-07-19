//
// This is only a SKELETON file for the 'Resistor Color Duo' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const decodedValue = (colors) => {
  const colorValues = colors.map(color => COLORS.indexOf(color));
  return (colorValues[0]*10) + colorValues[1];
};

const COLORS =  [
  "black", "brown", "red", "orange", "yellow",
  "green", "blue", "violet", "grey", "white"
];