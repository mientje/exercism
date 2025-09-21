//
// This is only a SKELETON file for the 'Simple Cipher' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class Cipher {

  constructor(key=undefined) {
    this.cipherKey = (key) ? key.toLowerCase() : this.generateRandomKey();
  }

  alphabet = 'abcdefghijklmnopqrstuvwxyz';
  keyLetter = this.increaseKeyIndex();

  generateRandomKey() {
    const a = 96;
    const z = 122;
    let cipher = ''
    let i = 100;
    while (i >= 0) {
      cipher += String.fromCharCode(Math.ceil(Math.random() * (z - a) + a))
      i--;
    }
    return cipher;
  }

  increaseKeyIndex() {
    let keyIndex = -1;
    return function (reset=null) {
        if(reset === "reset") { 
            keyIndex =  -1;
            return keyIndex;
        }
        keyIndex = (keyIndex < this.cipherKey.length-1) ?
            keyIndex + 1 : 0;
        return keyIndex;
    }
  }

  encode(plaintext) {
    this.keyLetter("reset")     
    return Array.from(plaintext).reduce((curletter, letter) => {
      const keyDigit = this.cipherKey[this.keyLetter()]
      const numValueLetter = Number(this.alphabet.indexOf(letter));
      const numValueKey = Number(this.alphabet.indexOf(keyDigit));
      const encodedIndex = numValueLetter + numValueKey;
      return (encodedIndex > 25) ? 
        curletter + this.alphabet[encodedIndex - 26] : 
        curletter + this.alphabet[encodedIndex];
    }, '')
  }
  decode(encodedText) {
    this.keyLetter("reset")     
    return Array.from(encodedText).reduce((curletter, letter) => {
      const keyDigit = this.cipherKey[this.keyLetter()]
      let numValueLetter = this.alphabet.indexOf(letter);
      let numValueKey = this.alphabet.indexOf(keyDigit);
      if(numValueKey > numValueLetter) {
        numValueKey = numValueKey - numValueLetter
        const reversed = this.alphabet.split('').reverse().join('')
        const reversedLetter = reversed[numValueKey];
        numValueLetter = this.alphabet.indexOf(reversedLetter);
        return curletter + this.alphabet[numValueLetter + 1];
      }
      return curletter + this.alphabet[numValueLetter - numValueKey];
    },'' );
  }

  set key(key=undefined) {
    this.cipherKey = (key) ? key : this.generateRandomKey();
  }

  get key() {
    return this.cipherKey;
  }
 
}
