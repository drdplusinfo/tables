<?php
namespace DrdPlus\Tables\Fatigue;

use DrdPlus\Tables\AbstractMeasurement;

class FatigueMeasurement extends AbstractMeasurement
{
    const FATIGUE = 'fatigue';

    public function __construct($value, $unit = self::FATIGUE)
    {
        parent::__construct($value, $unit);
    }

    public function getPossibleUnits()
    {
        return [self::FATIGUE];
    }

}
