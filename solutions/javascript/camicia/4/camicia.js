//
// This is only a SKELETON file for the 'Camicia' exercise. It's been provided as a
// convenience to get you started writing code faster.
//

export const simulateGame = (playerA, playerB) => {
	const numCards = [...playerA, ...playerB].length;
	const camicia = new Game(playerA, playerB);
 	
	do {
		camicia.addRound();	
 		const loops = camicia.compareRounds();
 		if(loops === 2) { 	
			return { status : "loop", tricks : camicia['tricks'], cards : camicia['cardsPlayed'] };
		}
		camicia.playHand();
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
 	this.playerA = playerA;	 
	this.playerB = playerB;
	this.playerName = "playerB"; 
	this.setAllPlayers = () => {
 		return function() { 
			this.playerName = (this.playerName === 'playerA') ? 
				'playerB' : 'playerA';  
			return this.playerName;
		};
	};
	this.setPlayerName = this.setAllPlayers();
	this.addToPile = () => {
		this.pile.push(this[this.playerName].shift());								
		this.cardsPlayed += 1;
		return this;
	}
	this.setPayment = (thrown) => {
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
	this.collectPile = (piletaker = this.setPlayerName()) => {
		this[piletaker].push(...this.pile.splice(0));
		this.tricks += 1;
	}
	this.oneRound = (round, lastRound) => {
		let loops = 0;
		for(let i = 0; i < round.length; i++) {
			if(round[i] === lastRound[i]) { 
				loops += 1 
			} else { break; }
		}
		return loops;
	}
	this.addRound = () => {
		const roundsCopy = [ [...this.playerA], [...this.playerB]];
		this.rounds.push([]);

		roundsCopy.forEach(round => {
			round = round.map(el => { 
				if(/\d/.test(el)) {
					el = '-'
				}
				return el;
			}).join('');
			this.rounds[this.rounds.length-1].push(round);
		});
	}
	this.compareRounds = () => {
		let loops = 0;
		if(this.rounds.length > 1) {
			const lastRound = this.rounds[this.rounds.length-1];
			for(let i = 0; i < this.rounds.length-1; i++) {
				loops = this.oneRound(this.rounds[i], lastRound);
				if(loops === 2) { return loops; }
			}
		}
		return loops.length;
	}
	this.pay = () => {
		this.payment = this.setPayment(this.pile[this.pile.length-1]);
		if(this.payment != "number") {
			const payerName = this.setPlayerName();
			while(this.payment > 0) {
				if(this[payerName].length === 0) {   
					this.collectPile();
					return;
				}
				this.addToPile();
				if(/\D/.test(this.pile[this.pile.length-1])) {
					return this.pay();
				}
				this.payment--;
				if(this.payment === 0) {
					const piletaker = (payerName === "playerA") ? "playerB" : "playerA";
					this.collectPile(piletaker);
					return;
				}	
			}
		}
	}
	this.playHand = () => {
		this.setPlayerName();
		if(this[this.playerName].length === 0 ) {
			this.collectPile();
			return;
		}
		this.addToPile();
		this.pay();
	}
};

 
