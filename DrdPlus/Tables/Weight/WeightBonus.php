<?php
namespace DrdPlus\Tables\Weight;

use DrdPlus\Tables\Parts\AbstractBonus;

class WeightBonus extends AbstractBonus
{
    /**
     * @var WeightTable
     */
    private $weightTable;

    /**
     * @param int $value
     * @param WeightTable $weightTable
     */
    public function __construct($value, WeightTable $weightTable)
    {
        $this->weightTable = $weightTable;
        parent::__construct($value);
    }

    /**
     * @return Weight
     */
    public function getWeight()
    {
        return $this->weightTable->toWeight($this);
    }

}
