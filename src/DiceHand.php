<?php
declare(strict_types=1);

namespace Hile14\Dice;

class DiceHand
{
    private $dices;
    private $values;
    private $graphic;

    public function __construct(int $dices = 5)
    {
        $this->dices  = [];
        $this->values = [];
        $this->graphic = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new DiceGraphic();
            $this->values[] = null;
            $this->graphic[] = null;
        }
    }

    public function roll()
    {
        $temp = count($this->dices);
        for ($i = 0; $i < $temp; $i++) {
            $this->values[$i] = $this->dices[$i]->rollDice();
            $this->graphic[$i] = $this->dices[$i]->graphic();
        }
    }

    public function values()
    {
        return $this->values;
    }

    public function getGraphic()
    {
        return $this->graphic;
    }

    public function sum()
    {
        $tempNr = 0;
        $temp = count($this->values);
        for ($i = 0; $i < $temp; $i++) {
            $tempNr += $this->values[$i];
        }
        return $tempNr;
    }
}
