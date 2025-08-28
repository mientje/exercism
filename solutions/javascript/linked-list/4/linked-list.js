//
// This is only a SKELETON file for the 'Linked List' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class LinkedList {
  constructor(number=0) {
    this.start = { next : null};
    this.number = number;
  }

  push(node) { 
    const lastNode = this.findNode();
    lastNode.next = { station: node,  next : null, previous : lastNode }  
    this.number += 1;
    return node;
  }

  pop() {
    const lastNode = this.findNode();
    this.number -= 1;
    const lastStation = lastNode.station
    lastNode.previous.next = null; 
    return lastStation;
  }

  findNode(value = null) {
    let next = this.start;
    while(next.next != null) {
      next = next.next;
      if(value && next.station === value) { return next; }
    }       
    return next; 
  }

  shift() {
    const firstNode = this.start.next;
    this.start.next = this.start.next.next;
    this.number -= 1;
    return firstNode.station;
  }

  unshift(node) {
    const firstNode = this.start.next;
    this.start.next = { station : node, next : firstNode, previous : null}; 
    this.number += 1;
    return this.start.next.station;
  }

  delete(value) {
    const curNode = this.findNode(value);
    const nextNode = curNode.next;
    const previousNode = curNode.previous
    if(curNode.station != value) { return }
    if(!previousNode && !nextNode) { this.start.next = null }
    if(!previousNode) { return this.unshift(value); }              
    else if(!nextNode) { return this.pop() }
    previousNode.next = nextNode; 
    nextNode.previous = previousNode
    this.number -= 1;
  }

  count() {
    return this.number;
  }
}