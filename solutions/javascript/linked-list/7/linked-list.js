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
    if(!this.head) {
      this.head = new Node(node, null, null);
      return node;
    }
    else if(!this.tail) {
      this.tail = new Node(node, null, this.head);
      this.head.next = new Node(node, null, this.head);
      return node;
    }
    if(this.tail.previous !== null) {
      this.tail = new Node(node, null, this.tail.previous.next);
      this.tail.previous.next = this.tail;
      return node;
    } 
  }
  pop() {
    const lastNodeStation = (this.tail) ? this.tail.station : 
        (this.head) ? this.head.station : null;

    if(this.head.station === lastNodeStation ) {
      this.head = null
      return lastNodeStation;
    }
    else if(this.tail && this.tail.station === this.head.station) {
      this.tail = null;
      this.head = null;
    }
    else {
      let lastNode = this.tail;
      this.tail.previous.next = null;
      this.tail = lastNode.previous;
      if(this.tail.station === this.head.station) {
          this.tail = null;
          this.head.next = null;
      }
    }

    return lastNodeStation;
  }  
  shift() {
    const firstNodeStation = (this.head.station) ? this.head.station : null;

    if(this.head.next === null) { 
        this.head = null;
        this.tail = null;
    }
    else {
      this.head = this.head.next;
      this.head.previous = null;
    }
    return firstNodeStation;
  }
  unshift(station) {

    if(!this.head) {
        this.push(station);
    } 
    else {
      const firstNode = this.head;
      const newNode = new Node(station, firstNode, null);
      this.head = newNode;
      this.head.next.previous = newNode;
    }
    return station;
  }
  delete(value) {
    if(this.head && value === this.head.station) {
      if(!this.tail) { this.head.next = null }
      return this.shift();
    }
    else if(this.tail && value === this.tail.station) {
      return this.pop();
    }
    const curNode = this.findNode(value);
    if(curNode.station != value) { return }
    const nextNode = curNode.next;
    const previousNode = curNode.previous
    previousNode.next = nextNode; 
    nextNode.previous = previousNode
  }
  findNode(value = null, countNum=false) {
    if(this.head === null) { 
        return (!countNum) ? this.head : 0 
    } 
    let number = 1;
    let next = this.head;
    while(next.next != null) {
      if(value && next.station === value) { return next; }
      next = next.next;
      number++;
    }       
    return (countNum) ? number : next;
  }
  count() {
    return this.findNode(null, true);
  }
}