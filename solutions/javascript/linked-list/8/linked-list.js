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
    if(this.head && value === this.head.station) {
      return this.shift();
    }
    else if(this.tail && value === this.tail.station) {
      return this.pop();
    }
    const curNode = this.findNode(value);
    if(!curNode) { return }
    const nextNode = curNode.next;
    const previousNode = curNode.previous
    previousNode.next = nextNode; 
    nextNode.previous = previousNode
  }
  findNode(value = null) {
    if(!this.head) { return null; } 
    let next = this.head;
    while(next.next != null) {
      if(value && next.station === value) { return next; }
      next = next.next;
    }
    return (next.next) ? next : null;
  }
  count() {
    if(!this.head) { return 0; } 
    else if(this.head === this.tail) { return 1; } 
    let number = 1;
    let next = this.head;
    while(next.next != null) {
      next = next.next;
      number++;
    }
    return number;
  }
}