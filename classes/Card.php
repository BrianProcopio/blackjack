<?php

namespace blackjack\classes;

class Card
{
    /**
     * @var integer
     */
    private $value;

    /**
     * @var string
     */
    private $suite;

    /**
     * @var string
     */
    private $face;

    public function __construct()
    {
        $this->value = rand(2, 11);
        $this->suite = substr(str_shuffle("SCHD"), 0, 1);
        $this->face = $this->getFaceFromValue($this->value);
    }

    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getSuite()
    {
        return $this->suite;
    }
    
    public function getFace()
    {
        return $this->face;
    }

    private function getFaceFromValue($value)
    {
        $faceCards = 'KQJT';
        $face = $value;

        if ($face === 10) {
            $face = substr(str_shuffle($faceCards), 0, 1);
        } else if ($face === 11) {
            $face = 'A';
        }

        return $face === 'T' ? 10 : $face;
    }
    
    public function __toString()
    {
        return $this->face . $this->suite;
    }
}