<?php
namespace DrdPlus\Tables\Weight;

use DrdPlus\Tables\Parts\AbstractBonus;
use DrdPlus\Tables\Parts\AbstractMeasurementWithBonus;

class Weight extends AbstractMeasurementWithBonus
{
    const KG = 'kg';

    /**
     * @var WeightTable
     */
    private $weightTable;

    public function __construct($value, $unit, WeightTable $weightTable)
    {
        $this->weightTable = $weightTable;
        parent::__construct($value, $unit);
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits()
    {
        return [self::KG];
    }

    /**
     * @return AbstractBonus
     */
    public function getBonus()
    {
        return $this->weightTable->toBonus($this);
    }

}
