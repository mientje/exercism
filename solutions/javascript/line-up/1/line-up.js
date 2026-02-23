//
// This is only a SKELETON file for the 'Line Up' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const format = (name, number) => {
	const numString = number.toString();
	const lastNumber = numString[numString.length-1];
	const oneBeforeLast = (numString[numString.length-2] ===  "1") ? true  : false;
	let endString = "";
	if(lastNumber === "1") { 
		endString = (oneBeforeLast) ? "th" : "st";
	}
	else if(lastNumber === "2") { 
		endString = (oneBeforeLast) ? "th" : "nd";
	}
	else if(lastNumber === "3") { 
		endString = (oneBeforeLast) ? "th" : "rd";
	}
	else {		
		endString = "th";
	}
    return `${name}, you are the ${number}${endString} customer we serve today. Thank you!`
};
