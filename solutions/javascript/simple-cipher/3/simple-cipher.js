//
// This is only a SKELETON file for the 'Simple Cipher' exercise. It's been provided as a
// convenience to get you started writing code faster.
//


export class Cipher {

  constructor(key=undefined) {
    this.cipherKey = (key) ? key.toLowerCase() : this.generateRandomKey();
  }

  alphabet = 'abcdefghijklmnopqrstuvwxyz';
  keyIndex = this.increaseKeyIndex()

  generateRandomKey() {
    const a = 96;
    const z = 122;
    let cipher = ''
    for (let i = 100; i >= 0; i--) {
        cipher += String.fromCharCode(Math.ceil(Math.random() * (z - a) + a))
    }
    return cipher;
  }

  increaseKeyIndex(iterator) {
    let keyIndex = -1;
    return function (iterator) {
      if(iterator === 0) { 
        keyIndex = 0;
      }
      else {
        keyIndex = (keyIndex < this.cipherKey.length-1) ?
          keyIndex + 1 : 0;
      }
      return keyIndex;
    }
  }    

  encode(plaintext) {
    return plaintext.split('').map((letter, index) => {
      let { numLetter, numKey } = this.numValues(letter, this.keyIndex(index));
      const encodedIndex = numLetter + numKey;
      return (encodedIndex > 25) ? 
        this.alphabet[encodedIndex - 26] : 
        this.alphabet[encodedIndex];        
    }).join('');
  }

  decode(encodedText) {
    const reversed = this.alphabet.split('').reverse().join('')
    return encodedText.split('').map((letter, index) => {
      let { numLetter, numKey } = this.numValues(encodedText[index], this.keyIndex(index));
      if(numKey > numLetter) {
          numLetter = this.alphabet.indexOf(reversed[numKey - numLetter]);
          return this.alphabet[numLetter + 1];
      }
      return this.alphabet[numLetter - numKey];
    }).join('')        
  }

  numValues(character, keyIndex) {
    return {
      numLetter : this.alphabet.indexOf(character),
      numKey :  this.alphabet.indexOf(this.cipherKey[keyIndex])
    }
  }

  get key() {
    return this.cipherKey;
  }
 
}
