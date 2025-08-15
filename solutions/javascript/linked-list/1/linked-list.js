//
// This is only a SKELETON file for the 'Linked List' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class LinkedList {
  push(node) { 
    const newVersion = this.createVersion(node);
    const newName = `node-${node}-v${newVersion}`;
    const newNode = {};
    newNode["version"] = newVersion;      
    newNode["number"] = node;
    newNode["last"] = newName;
    if(Object.keys(this).length === 0) {
      newNode["first"] = newName;     
    }
    for(let key in this) {
      if(this[key].hasOwnProperty("last")) {
        const lastNode = this[key];
        lastNode["next"] =  newName;
        newNode["previous"] = lastNode["last"];
        delete lastNode["last"];
      } 
    }
    this[newName] = newNode;
    return newNode["number"];
  }

  pop() {
    for(let key in this) {
      if(this[key].hasOwnProperty('last')) {
        const popNode = this[key];
        const previousNode = this[popNode["previous"]];
        if(previousNode) {
          previousNode['last'] = `node-${previousNode["number"]}-v${previousNode["version"]}`;
        }
        delete this[key];
        return popNode["number"];  
      }
    }
  }

  shift() {
    for(let key in this) {
      if(this[key].hasOwnProperty('first')) {
        const firstNode = this[key]; 
        const nextNode = this[firstNode["next"]];
        if(nextNode) {
          nextNode["first"] =  key;
          delete nextNode["previous"]
        }
        delete this[key];
        return firstNode["number"];
      }
    }
  }

  unshift(node) {
    const newVersion = this.createVersion(node);
    const newName = `node-${node}-v${newVersion}`;     
    const newNode = {};
    newNode["number"] = node;
    newNode["version"] = newVersion; 
    newNode["first"] = node;
    if(Object.keys(this).length === 0) {
      newNode["last"] = node;      
    }
    for(let key in this) {
      if(this[key].hasOwnProperty("first")) {
        const firstNode = this[key];
        firstNode["previous"] = newName;
        newNode["next"] =  `node-${firstNode["number"]}-v${firstNode["version"]}`;
        delete firstNode["first"];
      } 
    }
    this[`node-${newNode["number"]}-v${newNode["version"]}`] = newNode;
    return newNode["number"];
  }

  delete(node) {
    const found = this.findVersion(node);
    if(found === undefined) { return; }
    const version = Number(found.slice(found.indexOf('v')+1));
    const deleteNodeStr = `node-${node}-v${version}`
    const deleteNode = this[deleteNodeStr];
    const nextNode = this[deleteNode["next"]];
    const previousNode = this[deleteNode["previous"]];
    const nextNodeStr = (nextNode) ?  `node-${nextNode["number"]}-v${nextNode["version"]}` : '';
    const previousNodeStr = (previousNode) ? `node-${previousNode["number"]}-v${previousNode["version"]}` : '';
    if(deleteNode["first"] && nextNode) {
      nextNode["first"] =  nextNodeStr;
      delete nextNode["previous"];
    }
    else if (deleteNode["last"] && previousNode) {
      previousNode["last"] = previousNodeStr;        
      delete previousNode["next"];
    }
    else if(previousNode && nextNode) {
      previousNode["next"] = nextNodeStr;
      nextNode["previous"] = previousNodeStr; 
    }
    delete this[deleteNodeStr];
  }

  count() {
    return Object.keys(this).length;
  }

  findVersion(node) {
    const keys = Object.keys(this);
    const regex = new RegExp(`node-${node}-v\\d+`);
    return keys.find(key => key.match(regex));
  }

  createVersion(node) {
    const found = this.findVersion(node);
    return (found != undefined) ?
        Number(found.slice(found.indexOf('v')+1)) + 1 : 1;
  }
}
