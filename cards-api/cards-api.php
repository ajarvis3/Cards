<?php
class Card {
    function __construct($suit, $rank) {
        $this->suit = $suit;
        $this->rank = $rank;
    }
}

function shuff(& $deck) {
    $len = count($deck);
    for ($i = 0; $i < $len; $i++) {
        $index = mt_rand(0, $len - 1);
        $temp = $deck[$i];
        $deck[$i] = $deck[$index];
        $deck[$index] = $temp;
    }
}

function initializeDeck() {
    $suits = array("Clubs", "Diamonds", "Hearts", "Spades");
    $ranks = array("2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A");
    $deck = array();
    foreach ($suits as $suit) {
        foreach ($ranks as $rank) {
            $card = new Card($suit, $rank);
            array_push($deck, $card);
        }
    }
    shuff($deck);
    return $deck;
}

function getHands($deck, $num) {
    $hands = [];
    $remaining = count($deck);
    $currHand = 0;
    if ($num <= 0) {
        $hands = array($deck);
        return $hands;
    }
    for ($i = 0; $i < $num; $i++) {
        array_push($hands, array());
    }
    while ($remaining + $currHand >= $num) {
        array_push($hands[$currHand], $deck[$remaining - 1]);
        $currHand = $currHand + 1;
        if ($currHand == $num) {
            $currHand = 0;
        }
        $remaining = $remaining - 1;
    }
    return $hands;
}


$deck = initializeDeck();
$get = $_GET;
$num = $get['num'];
$data = json_encode(getHands($deck, $num));
header("Content-type: application/json");
echo $data;


?>