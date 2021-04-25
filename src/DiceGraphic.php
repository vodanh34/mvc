<?php
declare(strict_types=1);

namespace Hile14\Dice;

/**
* Dice class to roll the dice
*/
class DiceGraphic extends Dice
{
    const SIDES = 6;

    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    public function graphic()
    {
        return "dice-" . $this->getLastRoll();
    }
}
