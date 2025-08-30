//
// This is only a SKELETON file for the 'Grade School' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export class GradeSchool {

  constructor() {
    this.grades = {};
  }

  roster() {

    // GEBRUIK SET() 
     
    if(Object.keys(this.grades).length === 0) { return [] }

    return Object.entries(this.grades)
    .sort(([, a], [, b]) => a - b)
    .reduce((acc, [name, grade]) => { 
      if(Object.keys(acc[acc.length-1]).length === 0) {
        acc[acc.length-1][grade] = [name]
      } 
      else if(Number(Object.keys(acc[acc.length-1])[0]) === grade) {
        acc[acc.length-1][grade].push(name);
      }
      else {
        acc.push({ [grade] : [name] });
      }
      return acc; 
    }, [{}])
    .map(grades => Object.values(grades)[0].sort())
    .reduce((acc, grades) => acc.concat(grades))    
  }

  add(name, grade) {
    if(!name || !grade) { return false;}
    if(!Object.hasOwn(this.grades, name)) {
      this.grades[name] = grade; 
      return true;
    }
    return false;
  }

  grade(requestedGrade) {
    const requestedStudents = [];
    for(let grade in this.grades) {
      if(this.grades[grade] === requestedGrade) { requestedStudents.push(grade)}
    }
    return requestedStudents.sort()
  }
}
