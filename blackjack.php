<form id="board">
    <input type="submit" value="Hit" name="hit">
    <input type="submit" value="Pass" name="pass">
    <input type="submit" value="Restart" name="restart">
</form>

<?php
error_reporting(E_ERROR);
function createDeck(){
    $faces = array(1,2,3,4,5,6,7,8,9,10,11,12,13);
    //ace, 2, 3, 4, 5, 6, 7, 8, 9, 10, jack, queen, king
    $values = array("a","b","c","d");
    //diamond, club, heart, spade
    $cards = array();
    for ($x = 0; $x != count($values); $x++){
        for ($y = 0; $y != count($faces); $y++){
            array_push($cards,$faces[$y].$values[$x]);
        }
    }
    return $cards;
}
function shuffleDeck($deck){
    $digits = array();
    $deck2 = array();
    while (count($digits) != count($deck)){
        $rand = rand(0,count($deck)-1);
        if (in_array($rand,$digits) == FALSE){
            array_push($digits,$rand);
        }
    }
    while (count($deck2) != count($deck)){
        for ($x = 0; $x != count($deck); $x++){
            array_push($deck2,$deck[$digits[$x]]);
        }
    }
    return $deck2;
}
function dealCards($deck,$cards){
    $dealt = array();
    for ($x = 0; $x != $cards; $x++){
        array_push($dealt,$deck[$x]);
    }
    if (count($dealt) == 1){
        return $dealt[0];
    }else{
        return $dealt;
    }
}
function decodeCard($card){
    if (is_array($card) == FALSE){
        $facesEncoded = array(1,2,3,4,5,6,7,8,9,10,11,12,13);
        $facesDecoded = array("ace","2","3","4","5","6","7","8","9","10","jack","queen","king");
        $valuesEncoded = array("a","b","c","d");
        $valuesDecoded = array("diamond","club","heart","spade");
        $intEncoded = filter_var($card,FILTER_SANITIZE_NUMBER_INT);
        $strEncoded = substr($card, -1);
        $intDecoded = $facesDecoded[array_search($intEncoded,$facesEncoded)];
        $strDecoded = $valuesDecoded[array_search($strEncoded,$valuesEncoded)];
        return $intDecoded." of ".$strDecoded."s";
    }else{
        $decodedCardArray = array();
        for ($x = 0; $x != count($card); $x++){
            array_push($decodedCardArray,decodeCard($card[$x]));
        }
        return $decodedCardArray;
    }
}
function getScore($hand){
    $values = array(11,2,3,4,5,6,7,8,9,10,10,10,10);
    $score = 0;
    for ($x = 0; $x != count($hand); $x++){
        $score = $score + $values[filter_var($hand[$x],FILTER_SANITIZE_NUMBER_INT)-1];
    }
    if ($score > 21){
        for ($x = 0; $x != count($hand); $x++){
            if ($hand[$x] == "1a" or $hand[$x] == "1b" or $hand[$x] == "1c" or $hand[$x] == "1d"){
                $score = $score - 10;
                break;
            }
        }
    }
    return $score;
}
function didBust($score){
    if ($score > 21){
        return TRUE;
    }elseif ($score = 21) {
        return FALSE;
    }else{
        return FALSE;
    }
}
session_start();
$_SESSION['busted'] = FALSE;
$_SESSION['pPassed'] = FALSE;
$_SESSION['cPassed'] = FALSE;
// require_once("player-input.php");
// no longer required, since player-input.php and blackjack.php have been consolidated into one file
if (isset($_GET['restart']) && $_GET['restart'] == "Restart") {
    session_unset();
}
if (isset($_GET['hit']) && $_GET['hit'] == "Hit") {
    if (didBust(getScore($_SESSION['pHand'])) == FALSE and $_SESSION['pPassed'] == FALSE){
        array_push($_SESSION['pHand'],dealCards($_SESSION['deck'],1));
        array_splice($_SESSION['deck'], 0,1);
    }
}
if (isset($_GET['pass']) && $_GET['pass'] == "Pass") {
    if (getScore($_SESSION['cHand']) < getScore($_SESSION['pHand'])){
        if (didBust(getScore($_SESSION['pHand'])) == FALSE and $_SESSION['pPassed'] == FALSE){
            if (getScore($_SESSION['cHand']) <= 16){
                while (getScore($_SESSION['cHand']) <= 16){
                    array_push($_SESSION['cHand'],dealCards($_SESSION['deck'],1));
                    array_splice($_SESSION['deck'], 0,1);
                }
            }
        }
    }
    $_SESSION['pPassed'] = TRUE;
}
if (isset($_SESSION['deck']) == FALSE){
    $_SESSION['deck'] = createDeck();
    $_SESSION['deck'] = shuffleDeck($_SESSION['deck']);
    $_SESSION['pHand'] = array();
    $_SESSION['cHand'] = array();
    $_SESSION['busted'] = FALSE;
    array_push($_SESSION['pHand'],dealCards($_SESSION['deck'],1));
    array_splice($_SESSION['deck'], 0,1);
    array_push($_SESSION['pHand'],dealCards($_SESSION['deck'],1));
    array_splice($_SESSION['deck'], 0,1);
    array_push($_SESSION['cHand'],dealCards($_SESSION['deck'],1));
    array_splice($_SESSION['deck'], 0,1);
    array_push($_SESSION['cHand'],dealCards($_SESSION['deck'],1));
    array_splice($_SESSION['deck'], 0,1);
}
echo "YOUR HAND: ";
echo "<br>";
for ($x = 0; $x != count($_SESSION['pHand']); $x++){
    echo " | ".decodeCard($_SESSION['pHand'][$x]);
    if ($x == count($_SESSION['pHand'])-1){
        echo " | ";
    }
}
echo "<br>";
echo "SCORE: ".getScore($_SESSION['pHand']);
echo "<br>";
echo "<br>";
echo "HOUSES HAND: ";
echo "<br>";
if ($_SESSION['pPassed'] == TRUE){
    for ($x = 0; $x != count($_SESSION['cHand']); $x++) {
        echo " | " . decodeCard($_SESSION['cHand'][$x]);
        if ($x == count($_SESSION['cHand']) - 1) {
            echo " | ";
        }
    }
}elseif (getScore($_SESSION['pHand']) > 21 or getScore($_SESSION['cHand']) > 21){
    for ($x = 0; $x != count($_SESSION['cHand']); $x++) {
        echo " | " . decodeCard($_SESSION['cHand'][$x]);
        if ($x == count($_SESSION['cHand']) - 1) {
            echo " | ";
        }
    }
}else{
    echo " | Unknown Card ";
    for ($x = 1; $x != count($_SESSION['cHand']); $x++) {
        echo " | " . decodeCard($_SESSION['cHand'][$x]);
        if ($x == count($_SESSION['cHand']) - 1) {
            echo " | ";
        }
    }
}
echo "<br>";
echo "<br>";
if (didBust(getScore($_SESSION['pHand'])) == TRUE){
    echo "You LOSE!";
}
if (didBust(getScore($_SESSION['cHand'])) == TRUE){
    echo "You WIN!";
}
if (didBust(getScore($_SESSION['pHand'])) == FALSE and didBust(getScore($_SESSION['cHand'])) == FALSE and $_SESSION['pPassed'] == TRUE){
    if (21-getScore($_SESSION['pHand']) > 21-getScore($_SESSION['cHand'])){
        echo "You LOSE!";
    }elseif (21-getScore($_SESSION['pHand']) == 21-getScore($_SESSION['cHand'])){
        echo "You WIN!";
    }else{
        echo "You WIN!";
    }
}