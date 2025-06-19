//
// This is only a SKELETON file for the 'Space Age' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const findOrbit = (planet) => {
    switch(planet) {
      case "mercury" : return 0.2408467;
      case "venus" : return 0.61519726;
      case "earth" : return 1.0;
      case "mars" : return 1.8808158;
      case "jupiter" : return 11.862615;
      case "saturn" : return 29.447498;
      case "uranus" : return 84.016846;
      case "neptune" : return 164.79132;
      default : return 'not a planet';
  }
}
  
export const age = (planet, time) => {
  const orbit = findOrbit(planet);
  if (orbit === "not a planet") {
    throw new Error("not a planet");
  }
  return Number(((time / 60 / 60 / 24 / 365.25) / orbit).toFixed(2));
};
