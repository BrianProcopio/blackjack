<?php

namespace blackjack\classes;

include_once 'Card.php';

class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $cards;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addCards($count = 1)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->cards[] = new Card();
        }

        return $this;
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function getTotals()
    {
        $totals = array();
        $nonAceTotal = 0;
        $aces = 0;

        foreach ($this->getCards() as $card) {
            if ($card->getValue() !== 11) {
                $nonAceTotal += $card->getValue();
            } else {
                $aces++;
            }
        }

        if ($aces === 0) {
            $totals[] = $nonAceTotal;
        }

        for ($i = 0; $i < $aces; $i++) {
            $totals[] = $nonAceTotal + 11;
            $totals[] = $nonAceTotal + 1;
        }

        return $totals;
    }
    
    public function getBestHand()
    {
        $bestHand = 0;

        foreach ($this->getTotals() as $total) {
            $div21 = $total / 21;
            if ($div21 >= $bestHand && $div21 <= 1) {
                $bestHand = $total;
            }
        }
        
        if ($bestHand === 0) {
            foreach ($this->getTotals() as $total) {
                $div21 = $total / 21;
                if ($bestHand === 0 || ($div21 <= $bestHand && $div21 > 1)) {
                    $bestHand = $total;
                }
            }
        }
        
        return $bestHand;
    }

    public function showHand()
    {
        $bestHand = $this->getBestHand();

        if ($bestHand > 21) {
            echo "You busted with $bestHand!";
        } else if ($bestHand === 21 && count($this->cards) === 2) {
            echo "You have Blackjack!";
        } else {
            echo "You have $bestHand.";
        }

        echo "\n";

        foreach ($this->cards as $card) {
            echo $card . " ";
        }

        echo "\n\n";
    }
}