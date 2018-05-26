<?php 

/* ----------------------------- */
/*------> Define Functions       */
/* ----------------------------- */

function buildDeck() {
	
	// Create an array for suits
	$suits = ['Clubs', 'Hearts', 'Spades', 'Diamonds'];

	// Create an array for cards
	$cards = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];

	foreach ($cards as $card) {
		foreach ($suits as $suit) {
			$deck[] = "$card of $suit";
		}
	}

	// Shuffle the deck & return
	shuffle($deck);
	return $deck;
}

// This function will calculate the value of a hand.
function valueHand($hand) {

	$value = 0;

	foreach ($hand as $card) {
		$cardArray = explode(' ', $card);

		switch ($cardArray[0]) {
			case 'Ace':
				$value += $card <= 10 ? 11 : 1;
				echo "$value" . PHP_EOL;
				break;

			case 'King':
				$value += 10;
				break;
			
			case 'Queen':
				$value += 10;
				break;

			case 'Jack':
				$value += 10;
				break;

			default:
				$value += (int)$card;
				break;
		}
	}

	return $value;
}
// echo cards in a hand
function showHand(string $what = null, array $hand, int $howMany = null)
{
	// if "showing" cards don't echo hand's value
	if ($what !== null) {
		echo "$what: " . PHP_EOL;
		showHand(null, $hand, $howMany);
		if (is_null($howMany)) echo "Value: " . valueHand($hand) . PHP_EOL;
		return;
	}

	for ($i=0; $i < ($howMany ?? count($hand)); $i++) {
		echo (string)$hand[$i] . PHP_EOL;
	}
}

/* ----------------------------- */
/*------> Initialize Variables   */
/* ----------------------------- */

$choice = null;

// build the deck of cards
$deck = buildDeck();

// initialize a dealer and player hand
$dealerHand = [];
$playerHand = [];

/* ----------------------------- */
/*------> Begin Main Logic       */
/* ----------------------------- */

// Deal the first two cards.
for ($i=1; $i <=2 ; $i++) { 
	$playerHand[] = array_pop($deck);
	$dealerHand[] = array_pop($deck);
}

// Echo the dealer hand, only showing the first card
showHand('Dealer showing', $dealerHand, 1);

// Echo player hand
showHand('You have', $playerHand);

// Allow player to "(H)it or (S)tay?" till they bust (exceed 21) or stay
while ($choice != 'S') {

	if (valueHand($playerHand) > 21) {
		echo "Busted!" . PHP_EOL;
		exit(0);
	}

	elseif (valueHand($playerHand) == 21) {
		echo "BlackJack! You Win!" . PHP_EOL;
		exit(0);
	}

	echo "(H)it or (S)tay? ";
	$choice = strtoupper(trim(fgets(STDIN)));

	if ($choice == 'H') {
		// Add card to player deck
		$playerHand[] = array_pop($deck);

		showHand('You have', $playerHand);
	}
}

// show the dealer's hand (all cards)
showHand('Dealer have', $dealerHand);

while (true) {

	if (valueHand($dealerHand) == valueHand($playerHand)) {
		echo "Push!" . PHP_EOL;
		exit(0);
	}

	if (valueHand($dealerHand) > 21) {
		echo "Dealer Busted!" . PHP_EOL;
		exit(0);
	}

	elseif (valueHand($dealerHand) == 21) {
		echo "BlackJack! Dealer Wins!" . PHP_EOL;
		exit(0);
	}

	elseif (valueHand($dealerHand) < random_int(15, 18)) {
		$dealerHand[] = array_pop($deck);
		showHand('Dealer Hits', $dealerHand);
	}
	else {
		// Dealer stays; evaluate against value of player hand
		if (valueHand($dealerHand) >= valueHand($playerHand)) {
			echo "Dealer Wins!" . PHP_EOL;
			exit(0);
		}
		else {
			echo "You Win!" . PHP_EOL;
			exit(0);
		}
	}

	sleep(1);
}
