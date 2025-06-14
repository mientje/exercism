//
// This is only a SKELETON file for the 'Pascals Triangle' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const rows = (numRows) => {
  const triangle = (numRows === 0) ? [] : [[1]];
  for(let x = 0; x < numRows -1; x++) {
    const newRow = [1, 1];
    for(let i = 0; i <= x; i++) {
      if(i <= x) {
        if(triangle[x][i+1]) {
          newRow.splice(i+1, 0, triangle[x][i] + triangle[x][i+1]);
        }
      }
    }
    triangle.push(newRow);
  }
  return triangle;
};
