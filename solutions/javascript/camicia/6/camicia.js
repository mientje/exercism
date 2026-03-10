//
// This is only a SKELETON file for the 'Camicia' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const simulateGame = (playerA, playerB) => {
	const numCards = playerA.length + playerB.length;
	const camicia = new Game(playerA, playerB);
 	
	do {
		camicia.addRound();	
 		if(camicia.compareRounds()) { 	
			return { status : "loop", tricks : camicia['tricks'], cards : camicia['cardsPlayed'] };
		}
		camicia.playHand();
	}
	while(playerA.length !== numCards && playerB.length !== numCards);
	return { status : "finished", tricks : camicia['tricks'], cards : camicia['cardsPlayed'] };
};

class Game { 
	constructor(playerA, playerB) {
		this.rounds = [];
		this.pile = [];
		this.tricks = 0;
		this.cardsPlayed = 0;
		this.payment = 0;
		this.playerA = playerA;	 
		this.playerB = playerB;
		this.playerName = "playerB"; 
	}
	setPlayerName = () => { 
		this.playerName = (this.playerName === 'playerA') ? 
				'playerB' : 'playerA';  
		return this.playerName;
	}
	addToPile = () => {
		this.pile.push(this[this.playerName].shift());								
		this.cardsPlayed += 1;
		return this;
	}
	setPayment = (thrown) => {
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
	collectPile = (piletaker = this.setPlayerName()) => {
		this[piletaker].push(...this.pile.splice(0));
		this.tricks += 1;
	}
	addRound = () => {
		let roundsCopy = [ ...this.playerA, '|', ...this.playerB ];
		roundsCopy = roundsCopy.
			map(el => (/\d/.test(el)) ? '-' : el ).join('');
		this.rounds.push(roundsCopy);
	}
	compareRounds = () => {
		let loops = 0;
		const roundsCopy = [...this.rounds];
		const last = roundsCopy.pop();
		return roundsCopy.includes(last);
	}
	playerRunsOutOfCards = () => {
		if(this[this.playerName].length === 0) {   
			this.collectPile();
			return true;
		}
		return false;
	}
	pay = () => {
		this.payment = this.setPayment(this.pile[this.pile.length-1]);
		if(this.payment === "number") {
			return;
		}
		this.setPlayerName();
		while(this.payment > 0) {
			if(this.playerRunsOutOfCards()) { return; }
			this.addToPile();
			// a new payer card is drawn
			if(/\D/.test(this.pile[this.pile.length-1])) {
				return this.pay();
			}
			this.payment--;
			if(this.payment === 0) {
				// payer has been set to player, but the pile is taken 
				// by the other who will also start the next round 
				const piletaker = (this.playerName === "playerA") ? "playerB" : "playerA";
				this.collectPile(piletaker);
				return;
			}	
		}
	}
	playHand = () => {
		this.setPlayerName();
		if(this.playerRunsOutOfCards()) { return; }
		this.addToPile();
		this.pay();
	}
};
