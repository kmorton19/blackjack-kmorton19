<?php
session_start();
require_once(player-input.php);
if (isset($_SESSION)) {
    if (isset($_GET['new']) && $_GET['new'] == "New") {
        session_unset();
    }
    if (!isset($_SESSION['randDeck'])) {
        $_SESSION['deck'] = [
            ["name" => "Ace of Spades", "value" => 11],
            ["name" => "Two of Spades", "value" => 2],
            ["name" => "Three of Spades", "value" => 3],
            ["name" => "Four of Spades", "value" => 4],
            ["name" => "Five of Spades", "value" => 5],
            ["name" => "Six of Spades", "value" => 6],
            ["name" => "Seven of Spades", "value" => 7],
            ["name" => "Eight of Spades", "value" => 8],
            ["name" => "Nine of Spades", "value" => 9],
            ["name" => "Ten of Spades", "value" => 10],
            ["name" => "Jack of Spades", "value" => 10],
            ["name" => "Queen of Spades", "value" => 10],
            ["name" => "King of Spades", "value" => 10],
            ["name" => "Ace of Clubs", "value" => 11],
            ["name" => "Two of Clubs", "value" => 2],
            ["name" => "Three of Clubs", "value" => 3],
            ["name" => "Four of Clubs", "value" => 4],
            ["name" => "Five of Clubs", "value" => 5],
            ["name" => "Six of Clubs", "value" => 6],
            ["name" => "Seven of Clubs", "value" => 7],
            ["name" => "Eight of Clubs", "value" => 8],
            ["name" => "Nine of Clubs", "value" => 9],
            ["name" => "Ten of Clubs", "value" => 10],
            ["name" => "Jack of Clubs", "value" => 10],
            ["name" => "Queen of Clubs", "value" => 10],
            ["name" => "King of Clubs", "value" => 10],
            ["name" => "Ace of Hearts", "value" => 11],
            ["name" => "Two of Hearts", "value" => 2],
            ["name" => "Three of Hearts", "value" => 3],
            ["name" => "Four of Hearts", "value" => 4],
            ["name" => "Five of Hearts", "value" => 5],
            ["name" => "Six of Hearts", "value" => 6],
            ["name" => "Seven of Hearts", "value" => 7],
            ["name" => "Eight of Hearts", "value" => 8],
            ["name" => "Nine of Hearts", "value" => 9],
            ["name" => "Ten of Hearts", "value" => 10],
            ["name" => "Jack of Hearts", "value" => 10],
            ["name" => "Queen of Hearts", "value" => 10],
            ["name" => "King of Hearts", "value" => 10],
            ["name" => "Ace of Diamonds", "value" => 11],
            ["name" => "Two of Diamonds", "value" => 2],
            ["name" => "Three of Diamonds", "value" => 3],
            ["name" => "Four of Diamonds", "value" => 4],
            ["name" => "Five of Diamonds", "value" => 5],
            ["name" => "Six of Diamonds", "value" => 6],
            ["name" => "Seven of Diamonds", "value" => 7],
            ["name" => "Eight of Diamonds", "value" => 8],
            ["name" => "Nine of Diamonds", "value" => 9],
            ["name" => "Ten of Diamonds", "value" => 10],
            ["name" => "Jack of Diamonds", "value" => 10],
            ["name" => "Queen of Diamonds", "value" => 10],
            ["name" => "King of Diamonds", "value" => 10]
        ];
        $_SESSION['randDeck'] = shuffle($_SESSION['deck']);
        $_SESSION['pass'] = 0;
        $_SESSION['position'] = 0;
    }
    if ($_SESSION['pass'] > 0){
        session_unset();
    }
}
//for ($x = 0; $x < count($deck); $x++){
//    var_dump (shuffle($deck[1]));
//    echo "<br/ >";
//}
shuffle($_SESSION['deck']);
$x = 0;
echo "You have been dealt the ";
echo $_SESSION['deck'][$x]["name"];
echo " and the ";
echo $_SESSION['deck'][$x+=1]["name"];
echo "<br />";
echo "And the value is ";
echo $_SESSION['deck'][$x--]["value"] += ($_SESSION['deck'][$x]["value"]);