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
      return this;
    }
    else if(!this.values && !list2.values) {
      return new List();
    }
    else if(!this.values && list2.values) {
      return list2;
    }
    else if(this.values && list2.values) {
      this.values = [...this.values, ...list2.values];
      return this;
    }
  }
  concat(lists) {
    if(!this.values && !lists.values) { 
      return this.emptyArray();
    }
    else {
      for(let i = 0; i < lists.values.length; i++) {
        this.values = [...this.values, ...lists.values[i].values];
      }
      return this;
    }
  }

  filter(el) {
    const filtered = [];
    for(let i = 0; i < this.values.length; i++) {
      if(el(this.values[i])) { 
        filtered[filtered.length] = this.values[i] 
      }
    }
    this.values = filtered;
    return this;
  }

  map(el) {
    if(!this.values) { 
      return this.emptyArray();
    }
    else {
      for(let i = 0; i < this.values.length; i++) {
        this.values[i] = el(this.values[i]);
      }
      return this;
    }
  }

  length() {
    return (!this.values) ? 0 : this.values.length;
  }

  foldl(el, accumulator) {
    let sum = 0;
    if(!this.values) {
      return accumulator;
    }
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
    let sum = 0;
    if(!this.values) {
      return accumulator;
    }
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
    if(!this.values) { 
      return this.emptyArray()
    }
    const reversed = [];
    for(let i = this.values.length-1; i >= 0; i--) {
      reversed[reversed.length] = (typeof this.values[i] === "number") ?
        this.values[i] : [...this.values[i]]; 
    }
    this.values = reversed;
    return this;

  }
  emptyArray() {
    this.values = [];
    return this;
  }
}
