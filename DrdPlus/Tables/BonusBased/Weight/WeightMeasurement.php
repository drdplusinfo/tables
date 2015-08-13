<?php
namespace DrdPlus\Tables\BonusBased\Weight;

use DrdPlus\Tables\AbstractMeasurement;

class WeightMeasurement extends AbstractMeasurement
{
    const KG = 'kg';

    public function __construct($value, $unit = self::KG)
    {
        parent::__construct($value, $unit);
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits()
    {
        return [self::KG];
    }

}
