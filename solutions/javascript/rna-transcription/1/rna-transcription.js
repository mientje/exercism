//
// This is only a SKELETON file for the 'RNA Transcription' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const toRna = (sequence) => {
  if(sequence.length === 0) { return ''}
  let nucs = (sequence.length > 1) ? sequence.split('') : [sequence];
  return nucs.map(function(nuc){
    switch(nuc) {
      case 'C':
        return nuc = 'G';
      case 'G':
        return nuc = 'C';
      case 'T':
        return nuc = 'A';
      case 'A' : 
        return nuc = 'U';
    }
  }).join(''); 
};
