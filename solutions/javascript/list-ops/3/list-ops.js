//
// This is only a SKELETON file for the 'List Ops' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class List {
  constructor(values=undefined) {
    this.values = values;
  }

  append(list2) {
    if(this.values && !list2.values) {
      return new List(this.values);
    }
    else if(!this.values && !list2.values) {
      return new List();
    }
    else if(!this.values && list2.values) {
      return new List(list2.values);
    }
    else if(this.values && list2.values) {
      return new List([...this.values, ...list2.values]);
    }
  }

  concat(lists) {
    if(!this.values && !lists.values) { 
      return new List([]);
    }
    else {
      let concatList = [...this.values];
      for(let i = 0; i < lists.values.length; i++) {
        concatList = [...concatList, ...lists.values[i].values];
      }
      return new List(concatList);
    }
  }

  filter(el) {
    const filtered = [];
    for(let i = 0; i < this.values.length; i++) {
      if(el(this.values[i])) { 
        filtered[filtered.length] = this.values[i] 
      }
    }
    return new List(filtered);
  }

  map(el) {
      if(!this.values) { return new List([])}
      const mapped = [];
      for(let i = 0; i < this.values.length; i++) {
        mapped[i] = el(this.values[i]);
      }
      return new List(mapped);
  }

  length() {
    return (!this.values) ? 0 : this.values.length;
  }

  foldl(el, accumulator) {
    if(!this.values) {
      return accumulator;
    }
    let sum = 0;
    for(let i = 0; i < this.values.length; i++) {
      if(i === 0) {
        sum = el(accumulator, this.values[0]);
      }
      else {
        sum = el(sum, this.values[i]);
      }
    }
    return sum;
  }

  foldr(el, accumulator) {
    if(!this.values) {
      return accumulator;
    }
    let sum = 0;
    for(let i = this.values.length-1; i >= 0; i--) {
      if(i === this.values.length-1) {
        sum = el(accumulator, this.values[this.values.length-1]);
      }
      else {
        sum = el(sum, this.values[i]);
      }
    }
    return sum;
  }

  reverse() {
    if(!this.values) { return new List([])}
    const reversed = [];
    for(let i = this.values.length-1; i >= 0; i--) {
      reversed[reversed.length] = (typeof this.values[i] === "number") ?
        this.values[i] : [...this.values[i]]; 
    }
    return new List(reversed);
  }
}
