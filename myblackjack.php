<?php 

/* ----------------------------- */
// Define Functions

// This function will build the deck.
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

// This function will output a player's hand.
function echoHand($hand, $hidden = false) {

}

// This function will calculate the value of a hand.
function valueHand($hand) {

    $value = 0;

    foreach ($hand as $card) {

        $cardArray = explode(' ', $card);

        switch ($cardArray[0]) {
            case 'Ace':
                // Refactor to ternary.
                if (valueHand($playerHand) <= 10) {
                    $value += 11;
                }

                else {
                    $value += 1;
                }

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

            case 'King':
                $value += 10;
                break;

            default:
                $value += $card;
                break;
        }  // end switch
    } // end foreach

    return $value;
}

// function isAce($card) {
//     if ($card) {
//         # code...
//     }
// }

/* ----------------------------- */
// Initialize Variables
$choice = null;

// build the deck of cards
$deck = buildDeck();

// initialize a dealer and player hand
$dealerHand = [];
$playerHand = [];

/* ----------------------------- */
// Begin Main Logic

// Deal the first two cards.
for ($i=1; $i <=2 ; $i++) { 
    $playerHand[] = array_pop($deck);
    $dealerHand[] = array_pop($deck);
}

// Echo the dealer hand, only showing the first card
echo "Dealer showing: {$dealerHand[0]}" . PHP_EOL;
//echo "Value: " . valueHand($dealerHand) . PHP_EOL;


// Echo player hand
echo "You have: " . PHP_EOL;
foreach ($playerHand as $playerCard) {
    echo "$playerCard" . PHP_EOL;
}

echo "Value: " . valueHand($playerHand) . PHP_EOL;

// Allow player to "(H)it or (S)tay?" till they bust (exceed 21) or stay
while ($choice != 'S') {

    // if ($valuePlayerHand > 21) {
    //     echo "Busted! You have $valuePlayerHand!" . PHP_EOL;
    //     exit(0);
    // }

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

    switch ($choice) {
        case 'H':
            // Add card to player deck
            $playerHand[] = array_pop($deck);

            // Echo player hand
            echo "You have: " . PHP_EOL;
            foreach ($playerHand as $playerCard) {
                echo "$playerCard" . PHP_EOL;
            }

            echo "Value: " . valueHand($playerHand) . PHP_EOL;

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
while (true) {

    if (valueHand($dealerHand) > 21) {
        echo "Dealer Busted!" . PHP_EOL;
        exit(0);
    }

    elseif (valueHand($dealerHand) == 21) {
        echo "BlackJack! Dealer Wins!" . PHP_EOL;
        exit(0);
    }

    elseif (valueHand($dealerHand) < 17) {

        $dealerHand[] = array_pop($deck);

        echo "Dealer showing: " . PHP_EOL;
        foreach ($dealerHand as $dealerCard) {
            echo "$dealerCard" . PHP_EOL;
        }

        echo "Value: " . valueHand($dealerHand) . PHP_EOL;
    }

    else {
        // Dealer stays; evaluate against value of player hand
        if (valueHand($dealerHand) >= valueHand($playerHand)) {
            echo "Dealer has: " . valueHand($dealerHand) . " and you have: " . valueHand($playerHand) . ".";
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

// at this point, if the player has more than 21, tell them they busted
// otherwise, if they have 21, tell them they won (regardless of dealer hand)

// if neither of the above are true, then the dealer needs to draw more cards
// dealer draws until their hand has a value of at least 17
// show the dealer hand each time they draw a card

// finally, we can check and see who won
// by this point, if dealer has busted, then player automatically wins
// if player and dealer tie, it is a "push"
// if dealer has more than player, dealer wins, otherwise, player wins

?>