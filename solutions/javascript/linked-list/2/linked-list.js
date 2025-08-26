//
// This is only a SKELETON file for the 'Linked List' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class LinkedList {
  constructor(end=null, number=0) {
    this.start = { next : null};
    this.number = number;
  }  
    
  findNode(value = null) {
    let next = this.start
    while(next.next != null) {
      next = next.next;
      if(value && next.station === value) { return next; }
    }       
    return next; 
  }

  push(node) { 
    const newNode = new Node(node, this.end);
    const next = this.findNode()
    newNode.previous = next;
    next.next = newNode;
    this.number += 1;
    return newNode["station"];
  }

  pop() {
    let lastNode = this.findNode()
    if(this.start.next === lastNode) { this.start.next = null }
    else { lastNode.previous.next = null };
    this.number -= 1;
    return lastNode.station;
  }

  shift() {
    const firstNode = this.start.next;
    this.start.next = this.start.next.next;
    this.number -= 1;
    return firstNode.station;
  }

  unshift(node) {
    let newNode = new Node(node, this.end, this.start.next);
    const firstNode = this.start.next;
    this.start.next = newNode; 
    if(firstNode) { firstNode.previous = newNode };
    this.number += 1;
    return this.start.next.station;
  }

  delete(value) {
    let curNode = this.findNode(value);
    // value does not exist in the list
    if(curNode.station != value) { return }
    const previousNode = curNode.previous;
    const nextNode = curNode.next
    if(previousNode && nextNode) {
      previousNode.next = nextNode;
      nextNode.previous = previousNode
    }
    else if(previousNode && !nextNode) {
      previousNode.next = nextNode;
    }
    this.number -= 1;
    return curNode.station;
  }

  count() {
    return this.number;
  }
}

export class Node {
  constructor(station, previous=null, next=null) {
    this.station = station;
    this.next = next;
    this.previous = previous;
  }
}