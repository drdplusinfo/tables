<?php
namespace DrdPlus\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

class WeightBonus extends AbstractBonus
{
    /**
     * @var WeightTable
     */
    private $weightTable;

    /**
     * @param int $value
     * @param WeightTable $weightTable
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
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
