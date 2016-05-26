<?php

namespace blackjack;

include_once 'classes/Dealer.php';
include_once 'classes/Player.php';

$time = date('H') < 12 ? "morning" : "afternoon";

echo "\n" . "Good " . $time . ". What is your name? ";

$playerNameHandle = fopen("php://stdin", "r");
$playerName = fgets($playerNameHandle);
fclose($playerNameHandle);

echo "Good " . $time . " " . trim($playerName) . ". Would you like to play blackjack? ";

$playBlackjackHandle = fopen("php://stdin", "r");
$playBlackjack = fgets($playBlackjackHandle);
if (substr(trim(strtolower($playBlackjack)), 0, 1) != 'y') {
    echo "\nMaybe next time.\n";
    exit;
}
fclose($playBlackjackHandle);

echo "\n";
echo "Great. Let's play!\n\n";

$dealer = new classes\Dealer();
$endGame = false;

if ($dealer->getBestHand() === 21 && count($dealer->getCards()) === 2) {
    echo "That was quick!\n";
    $dealer->showHand();
    $endGame = true;
}

$player = new classes\Player($playerName);
$player->addCards(2);
$player->showHand();
$playerTotal = $player->getBestHand();

while ($playerTotal < 21 && !$endGame) {
    $dealerCard = array_values($dealer->getCards())[0];
    echo "Dealer is showing $dealerCard.\nWould you like to hit or stand? ";
    $actionHandle = fopen("php://stdin", "r");
    $action = fgets($actionHandle);
    $action = trim(strtolower($action));
    if ($action != 'hit' && $action != 'h') {
        $winner = ($player->getBestHand() > $dealer->getBestHand()) || $dealer->getBestHand() > 21;
        echo "\n";
        $dealer->showHand();
        $endGame = true;
        if ($dealer->getBestHand() == $player->getBestHand()) {
            echo "It's a Push.\n\n";
        } else {
            echo $winner ? "You win! Congratulation!!\n\n" : "Better luck next time.\n\n";
        }
    } else {
        $player->addCards();
        $playerTotal = $player->getBestHand();
        echo "\n";
        $player->showHand();
    }
    fclose($actionHandle);
}