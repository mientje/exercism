// @ts-check
//
// The line above enables type checking for this file. Various IDEs interpret
// the @ts-check directive. It will give you helpful autocompletion when
// implementing this exercise.

/**
 * Removes duplicate tracks from a playlist.
 *
 * @param {string[]} playlist
 * @returns {string[]} new playlist with unique entries
 */
export function removeDuplicates(playlist) {
  return Array.from(createSet(playlist));
}

/**
 * Checks whether a playlist includes a track.
 *
 * @param {string[]} playlist
 * @param {string} track
 * @returns {boolean} whether the track is in the playlist
 */
export function hasTrack(playlist, track) {
  playlist = removeDuplicates(playlist);
  return (playlist.indexOf(track) < 0) ? false : true;
}

function createSet(lijst) {
  const mySet = new Set();
  lijst.forEach(item => mySet.add(item));
  return mySet;
}

/**
 * Adds a track to a playlist.
 *
 * @param {string[]} playlist
 * @param {string} track
 * @returns {string[]} new playlist
 */
export function addTrack(playlist, track) {
  const playSet = createSet(playlist);
  playSet.add(track);
  return Array.from(playSet);
}

/**
 * Deletes a track from a playlist.
 *
 * @param {string[]} playlist
 * @param {string} track
 * @returns {string[]} new playlist
 */
export function deleteTrack(playlist, track) {
  const playSet = createSet(playlist);
  if(playSet.has(track)) {
    playSet.delete(track);  
  }
  return Array.from(playSet);
}

/**
 * Lists the unique artists in a playlist.
 *
 * @param {string[]} playlist
 * @returns {string[]} list of artists
 */
export function listArtists(playlist) {
  const artists = playlist.map(song => song.split('-')[1].trim());
  return Array.from(createSet(artists));            
}
