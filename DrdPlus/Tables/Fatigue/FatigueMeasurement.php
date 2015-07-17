<?php
namespace DrdPlus\Tables\Fatigue;

use DrdPlus\Tables\AbstractMeasurement;
use Granam\Float\Tools\ToFloat;

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

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkUnit($unit);
        if ($this->getValue() !== ToFloat::toFloat($value)) {
            throw new \LogicException("Fatigue already has a value {$this->getValue()} and can not be replaced by $value");
        }
    }

}
