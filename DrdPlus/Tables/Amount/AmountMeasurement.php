<?php
namespace DrdPlus\Tables\Amount;

use DrdPlus\Tables\AbstractMeasurement;
use Granam\Float\Tools\ToFloat;

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

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkUnit($unit);
        if ($this->getValue() !== ToFloat::toFloat($value)) {
            throw new \LogicException(
                "The amount measurement accepts only {$this->getUnit()} and is already set to value of {$this->getValue()}"
            );
        }
    }

}
