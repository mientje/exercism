//
// This is only a SKELETON file for the 'Linked List' exercise. It's been provided as a
// convenience to get you headed writing code faster.
//

export class Node { 
  constructor (station=null, next=null, previous=null) {
    this.station = station;
    this.next = next;
    this.previous = previous;
  }
}

export class LinkedList {
  constructor() {
    this.head = null;
    this.tail = null;
  }
  push(node) { 
    const element = new Node(node, null, this.tail)
    if(this.tail) {
      this.tail.next = element;
    }
    else {
      this.head = element;
    }
    this.tail = element;
  }
  pop() {
    const lastStation = this.tail.station;
    if(this.tail === this.head) {
      this.head = null;
      this.tail = null;
    }
    else {
      this.tail = this.tail.previous;
    }
    return lastStation;
  }  
  shift() {
    const firstStation = this.head.station
    if(this.head === this.tail) {
        this.tail = null;
        this.head = null;
    }
    else {
      this.head = this.head.next;
      this.head.previous = null;
    }
    return firstStation
  }
  unshift(station) {
    const newElement = new Node(station, this.head, null);
    if(this.head) {
      this.head.previous = newElement;
    }
    this.head = newElement; 
    if(!this.tail) {
      this.tail = this.head;
    }    
  }
  delete(value) {
    let element = this.head;
    while(element) {
      if(element.station === value) { 
        break;
      }
      element = element.next
    }
    if(!element) { return;}
    else if(!element.previous) {
      this.head = (element.next) ? element.next : null;
    }
    else if(!element.next) {
      this.tail = element.previous;
      this.tail.next = null;
    }
    else {
      element.previous.next = element.next;
      element.next.previous = element.previous
    }
  }
  count() {
    let count = 0;
    let current = this.head;
    while(current) {
      current = current.next;
      count++;
    }  
    return count;s
  }
}