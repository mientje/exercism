//
// This is only a SKELETON file for the 'Yacht' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export 	const score = (dice, choice) => {
	const diceLog = { "1" : 0, "2" : 0, "3" : 0, "4" : 0, "5" : 0, "6" : 0 };
	dice.forEach((face) => diceLog[face] += 1);
		
	switch(choice) {
		case 'yacht' : 
			return yacht(diceLog);
		case 'ones' : 
			return ones(diceLog);
		case 'twos' : 
			return twos(diceLog); 
		case 'threes' : 
			return threes(diceLog); 
		case 'fours' : 
			return fours(diceLog);  
		case 'fives' : 
			return fives(diceLog);  			
		case 'sixes' : 
			return sixes(diceLog);  
		case 'full house' : 
			return fullhouse(dice, diceLog);
		case 'four of a kind' :
			return fourOfAKind(diceLog);
		case 'little straight' : 
			return littleStraight(dice);
		case 'big straight' :
			return bigStraight(dice);
		case 'choice' :
			return choose(dice);
	}		
};

const diceNumber = (num) => (log) => num * log[num];

const ones = diceNumber(1);
const twos = diceNumber(2);
const threes = diceNumber(3);
const fours = diceNumber(4);
const fives = diceNumber(5);
const sixes = diceNumber(6);	

const straight = (straightType) => (dice) => (dice.sort().toString() === straightType) ? 30 : 0; 

const littleStraight = straight("1,2,3,4,5");
const bigStraight = straight("2,3,4,5,6");

const fourOfAKind = (log) => {
	const entry = Object.entries(log).find(entry => entry[1] >= 4);
	return (entry) ? entry[0] * 4 : 0;
}

const yacht = (log) => (Object.values(log).find(val => val === 5)) ? 50 : 0;
 
const fullhouse = (dice, log) => {
	const two = Object.values(log).find(val => val === 2);
	const three =  Object.values(log).find(val => val === 3);
	return (two && three) ? choose(dice) : 0;
}
const choose = (dice) => dice.reduce((curval, nextval) => curval += nextval);
