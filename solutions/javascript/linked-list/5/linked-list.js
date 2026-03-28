//
// This is only a SKELETON file for the 'Linked List' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class LinkedList {
  constructor() {
    this.start = {next : null};
  }
  push(node) { 
    const lastNode = this.findNode();
    lastNode.next = { station: node, next : null, previous : lastNode} ;
    return node;
  }
  pop() {
    const lastNode = this.findNode();
    const lastStation = lastNode.station
    lastNode.previous.next = null; 
    return lastStation;
  }
  shift() {
    const firstNode = this.start.next;
    this.start.next = this.start.next.next;
    return firstNode.station;
  }
  unshift(node) {
    const firstNode = this.start.next;
    this.start.next ={ station: node, next : firstNode, previous : null} ;  
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
  }
  findNode(value = null, countNum=false) {
    let next = this.start;
    let number = 0;
    while(next.next != null) {
      next = next.next;
      if(value && next.station === value) { return next; }
      number++;
    }       
    return (countNum) ? number : next;
   }
  count() {
    return this.findNode(null, true);
  }
}