<?php
namespace DrdPlus\Tables\Base\Amount;

use DrdPlus\Tables\AbstractMeasurement;

class AmountMeasurement extends AbstractMeasurement
{
    const AMOUNT = 'amount';

    public function __construct($value, $unit = self::AMOUNT)
    {
        parent::__construct($value, $unit);
    }

    public function getPossibleUnits()
    {
        return [self::AMOUNT];
    }

}
