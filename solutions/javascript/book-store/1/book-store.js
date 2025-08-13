//
// This is only a SKELETON file for the 'BookStore' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const cost = (books) => {
  if(books.length == 0) { return 0; }
  books.sort();
  const groups = groupBooks(books);
  const firstCalculation =  calculateCosts(groups);
  const compared = redistributeGroups(groups);
  const secondCalculation = calculateCosts(compared);
  return (firstCalculation < secondCalculation) ? 
    firstCalculation : secondCalculation;
};

export const calculateCosts = (groups) => {
  let totalCost = 0;
  groups.forEach(group => {
    switch(group.length) {
      case 1 :
        totalCost += 800;
        break;
      case 2 : 
        totalCost += 2 * 8 * 95;
        break;
      case 3:
        totalCost += 3 * 8 * 90;
        break;
      case 4: 
        totalCost += 4 * 8* 80;
        break;
      case 5: 
        totalCost += 5 * 8 * 75;
        break;
      }
  })
  return totalCost;
}
 
export const groupBooks = (books) => {
  const groups = [];
  const bonusCeiling = 6;
  do {
      const group = [];
      for(let i = 1; i < bonusCeiling; i++) {
        const found = books.find(book => book === i)
        if(found != undefined) { 
            group.push(found)
            books.splice(books.indexOf(found), 1);
        }
        if(books.length === 0) { break; }
      }
      groups.push(group);
  } while(books.length > 0);
  return groups;
} 

const redistributeGroups = (groups) => {
    let { min, max, minIndex, maxIndex } =  diffArrayLengths(groups);
    if(max - min >= 2) {
        const book = groups[maxIndex].find(book => groups[minIndex].indexOf(book) < 0);
        groups[maxIndex].splice(groups[maxIndex].indexOf(book), 1)
        groups[minIndex].push(book);
        redistributeGroups(groups);
    }                
    return groups;               
}

const diffArrayLengths = (groups) => {
    const maxMin = groups.reduce((acc, group, index) => {
        if (group.length > acc["max"]) { 
            acc["max"] = group.length; 
            acc["maxIndex"] = index;
        }
        if(group.length < acc["min"] || acc["min"] === 0 ) {
            acc["min"] = group.length;
            acc["minIndex"] = index;
        }
        return acc;
    }, { min : 0, max : 0, minIndex : 0, maxIndex: 0 })
    return maxMin
} 