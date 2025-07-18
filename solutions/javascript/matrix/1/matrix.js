//
// This is only a SKELETON file for the 'Matrix' exercise. It's been provided as a
// convenience to get you started writing code faster.
//




export class Matrix {
  constructor(matrix) {
    this.matrix = matrix;
    this._rows = this.createRows(); 
    this._columns = this.createColumns();
  }
  createRows() {
    const rowStrings = this.matrix.split('\n');
    const rows = [];
    for(let x = 0, lengte = rowStrings.length; x < lengte; x++) {
      const numbers = rowStrings[x]
        .split(' ')
        .map(number => Number(number))
      rows.push(numbers);
    }
    return rows;
  }
  createColumns() {
    const columns = [];
    let y = 0;
    while (y < this._rows[0].length) {
      const col = [];
      this._rows.forEach(row => col.push(row[y]))
      columns.push(col);
      y++;
    }
    return columns;
  }
  get rows() {
    return this._rows;
  }
  get columns() {
    return this._columns;
  }  
}
