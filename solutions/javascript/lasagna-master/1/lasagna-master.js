/// <reference path="./global.d.ts" />
// @ts-check

/**
 * Implement the functions needed to solve the exercise here.
 * Do not forget to export them so they are available for the
 * tests. Here an example of the syntax as reminder:
 *
 * export function yourFunction(...) {
 *   ...
 * }
 */


export function cookingStatus(minutes) {
  if(minutes === undefined) {
    return 'You forgot to set the timer.';
  }
  else {
    return (Number(minutes) === 0) ? 'Lasagna is done.' : 'Not done, please wait.';
  }
}

export function preparationTime(layers, minutes=2) {
  return (minutes) ? layers.length * minutes : minutes;
}

export function quantities(layers) {
  let noodles = 0;
  let sauce = 0;
  layers.forEach(function(layer) {
    if(layer === "sauce") { sauce += 1}
    else if (layer === "noodles") { noodles += 1}
  })
  return { "noodles" : 50 * noodles, "sauce" : 0.2 * sauce }  
}

export function addSecretIngredient(friendIngred, myIngredients) {
  myIngredients.push(friendIngred[friendIngred.length-1]);
}

export function scaleRecipe(recipe, portions) {
  const copyRecipe = Object.assign({}, recipe);
  for(let ingredient in copyRecipe) {
    copyRecipe[ingredient] = (copyRecipe[ingredient] / 2) * portions;
  }
  return copyRecipe;
}
