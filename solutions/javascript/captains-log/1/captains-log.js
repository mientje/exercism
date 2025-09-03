// @ts-check

/**
 * Generates a random starship registry number.
 *
 * @returns {string} the generated registry number.
 */

// copied from https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/random
export function getRandomArbitrary(min, max) {
  return  Math.round(Math.random() * (max - min) + min).toString();
}

export function randomShipRegistryNumber() {
  return "NCC-"+ getRandomArbitrary(1000, 9999);
}

/**
 * Generates a random stardate.
 *
 * @returns {number} a stardate between 41000 (inclusive) and 42000 (exclusive).
 */
export function randomStardate() {
  return Math.random() * (42000.0 - 41000.0 ) + 41000.0;
}

/**
 * Generates a random planet class.
 *
 * @returns {string} a one-letter planet class.
 */
export function randomPlanetClass() {
  const planet = [ "D", "H", "J", "K", "L", "M", "N", "R", "T", "Y"]
  return planet[getRandomArbitrary(0, 9)];

}
