<?php
namespace DrdPlus\Tables\Measurements\Weight;

use DrdPlus\Codes\Units\WeightUnitCode;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;

class Weight extends AbstractMeasurementWithBonus
{
    const KG = WeightUnitCode::KG;

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
    public function getPossibleUnits(): array
    {
        return [self::KG];
    }

    /**
     * @return WeightBonus
     */
    public function getBonus(): WeightBonus
    {
        return $this->weightTable->toBonus($this);
    }

    /**
     * @return float
     */
    public function getKilograms(): float
    {
        return $this->getValue();
    }

    /**
     * @return WeightUnitCode
     */
    public function getUnitCode(): WeightUnitCode
    {
        return WeightUnitCode::getIt($this->getUnit());
    }
}