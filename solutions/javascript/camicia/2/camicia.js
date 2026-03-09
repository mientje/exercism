//
// This is only a SKELETON file for the 'Camicia' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const simulateGame = (playerA, playerB) => {
	const numCards = [...playerA, ...playerB].length;
	const camicia = new Game(playerA, playerB);
 	
	do {
		addRound(camicia);	
 		const loops = compareRounds(camicia);
 		if(loops === 2) { 	
			return { status : "loop", tricks : camicia['tricks'], cards : camicia['cardsPlayed'] };
		}
		playHand(camicia);
	}
	while(playerA.length !== numCards && playerB.length !== numCards);
	return { status : "finished", tricks : camicia['tricks'], cards : camicia['cardsPlayed'] };
};

function Game(playerA, playerB) { 
	this.rounds = [];
	this.pile = [];
	this.tricks = 0;
	this.cardsPlayed = 0;
	this.payment = 0;
 	this.setAllPlayers = function(playerAB) {
 		return function() { 
			this[playerAB] = (this[playerAB] === 'playerA') ? 
				'playerB' : 'playerA';  
			return this[playerAB];
		};
	};
	this.playerA = playerA;	 
	this.playerB = playerB;
	this.playerName = "playerB"; 
	this.setPlayerName = this.setAllPlayers("playerName");
	this.payerChange = false;
};

const addRound = (camicia) => {
	const { playerA, playerB, rounds } = camicia;
	const roundsCopy = [ [...playerA], [...playerB]];
	rounds.push([]);

	roundsCopy.forEach(round => {
		round = round.map(el => { 
			if(/\d/.test(el)) {
				el = '-'
			}
			return el;
		}).join('');
		rounds[rounds.length-1].push(round);
	});
	return rounds;
}

function oneRound(round, lastRound) {
	let loops = 0;
	for(let i = 0; i < round.length; i++) {
		if(round[i] === lastRound[i]) { 
			loops += 1 
		} else { break; }
	}
	return loops;
}

const compareRounds = (camicia) => {
	let loops = 0;
	const { rounds } = camicia;
	if(rounds.length > 1) {
		const lastRound = rounds[rounds.length-1];
		for(let i = 0; i < rounds.length-1; i++) {
			loops = oneRound(rounds[i], lastRound);
			if(loops === 2) { return loops; }
		}
	}
	return loops.length;
}

const playHand = (camicia) => {
	let { pile } = camicia
	
	const playerName = camicia.setPlayerName(camicia.playerName);
	if(camicia[playerName].length === 0 ) {
		camicia.tricks += 1;
		camicia.setPlayerName(camicia.playerName);
		camicia[camicia.playerName].push(...pile.splice(0));		
		return camicia;
	}
	addToPile(camicia);
	camicia.payment = setPayment(pile[pile.length-1]);
	if(camicia.payment != "number") {
		camicia = pay(camicia);
	}
	return camicia;
}

const addToPile = (camicia) => {
	const { pile, playerName } = camicia;
	pile.push(camicia[playerName].shift());								
	camicia['cardsPlayed'] += 1;
	return camicia;
}

const collectPile = (camicia, piletaker) => {
	camicia[piletaker]
		.push(...camicia['pile']
		.splice(0));
}

const setPayment = (thrown) => {
	switch(thrown) {
		case "J" :
			return 1;	
		case "Q" :
			return 2;	
		case "K" :
			return 3;	
		case "A" :
			return 4;	
		default :
			return "number";
	}	
}
 
const pay = (camicia) => {
	const { pile } = camicia;
	
	const payerName = camicia.setPlayerName(camicia.playerName);
	while(camicia.payment > 0) {
		if(camicia[payerName].length === 0) {
			camicia.tricks += 1;
			const playerName = camicia.setPlayerName(camicia.playerName);   
			collectPile(camicia, playerName)
			return camicia;
		}
		camicia = addToPile(camicia);
		const last = pile[pile.length-1];
		if(/\D/.test(last)) {
			camicia.payment = setPayment(last);
			return pay(camicia)
		}
		camicia.payment--;
		if(camicia.payment === 0) {
			if(/\D/.test(last)) {
				camicia.payment = setPayment(last);
				return pay(camicia)
			}
			const piletaker = (payerName === "playerA") ? "playerB" : "playerA";
			camicia.tricks += 1;
			collectPile(camicia, piletaker);
			return camicia;
		}	
	}
}

