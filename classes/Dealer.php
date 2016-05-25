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
    
    public function getTotal()
    {
        $total = 0;
        $converted = false;
        
        foreach ($this->getCards() as $card) {
            $total += $card->getValue();
        }

        if ($total > 21) {
            for ($i = 0; $i < count($this->cards) && !$converted; $i++) {
                $card = $this->cards[$i];
                if ($card->getValue() === 11) {
                    $total -= 10;
                    $card->setValue(1);
                    $converted = true;
                }
            }
        }
        
        return $total;
    }
    
    public function showHand()
    {
        $total = $this->getTotal();

        if (count($this->cards) === 2 && $total === 21) {
            echo "Dealer has Blackjack!";
        } else if ($total > 21) {
            echo "Dealer busts!";
        } else {
            echo "Dealer has $total.";
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
        
        while ($this->getTotal() < 17) {
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