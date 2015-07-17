<?php
namespace DrdPlus\Tables\Wounds;

use DrdPlus\Tables\AbstractMeasurement;
use Granam\Float\Tools\ToFloat;

class WoundsMeasurement extends AbstractMeasurement
{
    const WOUNDS = 'wounds';

    public function __construct($value, $unit = self::WOUNDS)
    {
        parent::__construct($value, $unit);
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits()
    {
        return [self::WOUNDS];
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkUnit($unit);
        if ($this->getValue() !== ToFloat::toFloat($value)) {
            throw new \LogicException("Wounds already have a value {$this->getValue()} and can not be replaced by $value");
        }
    }

}
