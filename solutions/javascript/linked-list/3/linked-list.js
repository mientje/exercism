//
// This is only a SKELETON file for the 'Linked List' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class LinkedList {

  constructor() {
    this.start = { next : null };
    this.number = 0;
  }  

  push(node) { 
    const lastNode = this.findNode()
    lastNode.next = { station: node,  next : null, previous : lastNode.station }  
    this.number += 1;
    return node;
  }
  
  pop() {
    let next = this.start
    while(next.next.next != null) {
      next = next.next;
    }       
    this.number -= 1;
    const lastStation = next.next.station
    next.next = null; 
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
    const station = this.start.next.station;
    this.start.next = this.start.next.next;
    this.number -= 1;
    return station;
  }
  
  unshift(node) {
    const firstNode = this.start.next;
    this.start.next = { station : node, next : firstNode, previous : null}; 
    this.number += 1;
    return this.start.next.station;
  }
  
  delete(value) {
    let curNode = this.findNode(value);
    const previousNode = (curNode.previous) ? this.findNode(curNode.previous) : null;
    const nextNode = curNode.next
    if(curNode.station != value) { return }
    if(previousNode) { previousNode.next = nextNode; }
    if(previousNode && nextNode) {
      nextNode.previous = previousNode.station
    } 
    this.number -= 1;
  }
  
  count() {
    return this.number;
  }
}