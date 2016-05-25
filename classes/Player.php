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

    public function getTotal()
    {
        $converted = false;
        $total = 0;

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

        if ($total > 21) {
            echo "You busted!";
        } else if ($total === 21 && count($this->cards) === 2) {
            echo "You have Blackjack!";
        } else {
            echo "You have $total.";
        }

        echo "\n";

        foreach ($this->cards as $card) {
            echo $card . " ";
        }

        echo "\n\n";
    }
}