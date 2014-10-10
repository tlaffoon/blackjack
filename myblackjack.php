<?php 

// create an array for suits
$suits = ['Clubs', 'Hearts', 'Spades', 'Diamonds'];

// create an array for cards
$cards = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];

// build a deck (array) of cards
// card values should be "VALUE SUIT". ex: "7 H"
// make sure to shuffle the deck before returning it
function buildDeck($suits, $cards) {
    foreach ($cards as $card) {
        foreach ($suits as $suit) {
            $deck[] = "$card of $suit";
        }
    }

    shuffle($deck);

    return $deck;
}

// build the deck of cards
$deck = buildDeck($suits, $cards);

//echo "$count($deck)";

//print_r($deck);

// initialize a dealer and player hand
$dealerHand = [];
$playerHand = [];

// dealer and player each draw two cards

for ($i=1; $i <=2 ; $i++) { 
    $playerHand[] = array_pop($deck);
    $dealerHand[] = array_pop($deck);
}

// echo the dealer hand, only showing the first card
echo "Dealer showing: {$dealerHand[0]}" . PHP_EOL;

// Echo player hand
echo "You have: " . PHP_EOL;
foreach ($playerHand as $playerCard) {
    echo "$playerCard" . PHP_EOL;
}

// allow player to "(H)it or (S)tay?" till they bust (exceed 21) or stay
while ($choice != 'S') {

    // if ($valuePlayerHand > 21) {
    //     echo "Busted! You have $valuePlayerHand!" . PHP_EOL;
    //     exit(0);
    // }

    echo "(H)it or (S)tay?" . PHP_EOL;
    $choice = strtoupper(trim(fgets(STDIN)));

    switch ($choice) {
        case 'H':
            // Add card to player deck
            $playerHand[] = array_pop($deck);

            // Echo player hand
            echo "You have: " . PHP_EOL;
            foreach ($playerHand as $playerCard) {
                echo "$playerCard" . PHP_EOL;
            }

            break;
        
        case 'S':
            // do nothing
            break;

        default:
            // do nothing
            break;
    }
}

// show the dealer's hand (all cards)
echo "Dealer showing: " . PHP_EOL;
foreach ($dealerHand as $dealerCard) {
    echo "$dealerCard" . PHP_EOL;
}

// at this point, if the player has more than 21, tell them they busted
// otherwise, if they have 21, tell them they won (regardless of dealer hand)

if ($valuePlayerHand > 21) {
    echo "Busted! You have $valuePlayerHand!" . PHP_EOL;
    exit(0);
}

elseif ($valuePlayerHand == 21) {
    echo "You Won!" . PHP_EOL;
}

// if neither of the above are true, then the dealer needs to draw more cards
// dealer draws until their hand has a value of at least 17
// show the dealer hand each time they draw a card

else {
    while ($valueDealerHand < 17) {
        $dealerHand[] = array_pop($deck);

        echo "Dealer showing: " . PHP_EOL;
        foreach ($dealerHand as $dealerCard) {
            echo "$dealerCard" . PHP_EOL;
        }

        sleep(1);
    }
}

// finally, we can check and see who won
// by this point, if dealer has busted, then player automatically wins
// if player and dealer tie, it is a "push"
// if dealer has more than player, dealer wins, otherwise, player wins



 ?>