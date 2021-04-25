<?php
declare(strict_types=1);

namespace Hile14\Dice;

/**
* Dice class to roll the dice
*/
class Dice
{
    private $number;
    private $lastRoll;
    private $face;

    public function __construct(int $face = 6)
    {
        $this->face = $face;
    }

    public function rollDice()
    {
        $this->number = rand(1, $this->face);
        $this->lastRoll = $this->number;
        return $this->number;
    }

    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
