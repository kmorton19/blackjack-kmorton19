<?php
session_start();
require_once("player-inpur.php");
if (isset($_SESSION)) {
    if (isset($_GET['new']) && $_GET['new'] == "reset") {
        session_unset();
    }
    if (!isset($_SESSION["deck"])) {
        $_SESSION["deck"] = [
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
        shuffle($_SESSION["deck"]);
        $_SESSION['position'] = 4;
        $_SESSION['playerValue'] = 0;
        $_SESSION['playerCards'] = array();
        $_SESSION['dealerValue'] = 0;
        $_SESSION['dealerCards'] = array();
    }

        switch ($_GET["action"]) {
            case 'deal':
                deal();
                break;
            case 'hit':
                hit ();
                break;
            case 'pass':
                pass ();
                break;
            default:
                break;
            }
    }
function deal() {
    $_SESSION['playerValue'] = $_SESSION["deck"][0]["value"] + $_SESSION["deck"][1]["value"];
    $_SESSION['playerCards'] = $_SESSION["deck"][0]["name"] . " and the " . $_SESSION["deck"][1]["name"];
        echo "You have been dealt the ";
        echo $_SESSION['playerCards'];
        echo " your total is ";
        echo $_SESSION["playerValue"];
        echo "<br />";
    $_SESSION['dealerCards'] = $_SESSION["deck"][2]["name"] . " and the " . $_SESSION["deck"][3]["name"];
    $_SESSION['dealerValue'] = $_SESSION["deck"][2]["value"] + $_SESSION["deck"][3]["value"];
        echo "The dealer has the ";
        echo $_SESSION["deck"][2]["name"];
        echo " and an unknown card";
}
function hit() {
    $_SESSION['playerCards']  = $_SESSION['playerCards'] . " and " . $_SESSION["deck"][$_SESSION['position']]["name"];
    $_SESSION['playerValue'] = $_SESSION['playerValue'] + $_SESSION["deck"][$_SESSION['position']]["value"];
    $_SESSION['position'] = ($_SESSION['position']) + 1;
    if ($_SESSION['playerValue'] > 21) {
        if (in_array("Ace", $_SESSION['player cards'], true)){
            $_SESSION['playerValue'] = $_SESSION['playerValue'] - 10;
        } else {
            echo "YOU BUST";
        }
    } else {
        echo "You have been dealt the ";
        echo $_SESSION['playerCards'];
        echo " your total is ";
        echo $_SESSION["playerValue"];
        echo "<br />";
        $_SESSION['dealerCards'] = $_SESSION["deck"][2]["name"] . " and the " . $_SESSION["deck"][3]["name"];
        $_SESSION['dealerValue'] = $_SESSION["deck"][2]["value"] + $_SESSION["deck"][3]["value"];
        echo "The dealer has the ";
        echo $_SESSION["deck"][2]["name"];
        echo " and an unknown card";
    }
}
function pass() {
if ($_SESSION['dealerValue'] <= 16) {
    $_SESSION['dealerCards'] = $_SESSION['dealerCards'] . $_SESSION["deck"][$_SESSION['position']]["name"];
    $_SESSION['dealerValue'] = $_SESSION['dealerValue'] + $_SESSION["deck"][$_SESSION['position']]["value"];
    $_SESSION['position'] = ($_SESSION['position']) + 1;
    echo "You have been dealt the ";
    echo $_SESSION['playerCards'];
    echo " your total is ";
    echo $_SESSION["playerValue"];
    echo "<br />";
    echo "The dealer has the ";
    echo $_SESSION['dealerCards'];
    echo " with a value of ";
    echo $_SESSION['dealerValue'];
} else {
    echo "The dealer had the ";
    echo $_SESSION['dealerCards'];
    echo "with a total of ";
    echo $_SESSION['dealerValue'];
}
}