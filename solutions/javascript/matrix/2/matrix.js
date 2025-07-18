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
    return this.matrix
      .split('\n')
      .map(row => row
        .split(' ')
        .map(number => Number(number)))
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
