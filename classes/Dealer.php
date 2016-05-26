<?php

namespace blackjack\classes;

include_once 'Card.php';

class Dealer
{
    /**
     * @var array
     */
    private $cards;

    public function __construct()
    {
        $this->cards = array();
        $this->drawCards();
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
        
        if (count($this->cards) === 2 && $bestHand === 21) {
            echo "Dealer has Blackjack!";
        } else if ($bestHand > 21) {
            echo "Dealer busts with $bestHand!";
        } else {
            echo "Dealer has $bestHand.";
        }
        
        echo "\n";
        
        foreach ($this->cards as $card) {
            echo $card . " ";
        }
        
        echo "\n\n";
    }
    
    private function drawCards()
    {
        if (count($this->cards) < 2) {
            $this->addCards(2);
        }
        
        while ($this->getBestHand() < 17) {
            $this->addCards();
        }
        
        return $this;
    }

    private function addCards($count = 1)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->cards[] = new Card();
        }
        
        return $this;
    }
}