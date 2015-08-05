<?php
namespace DrdPlus\Tables\Distance;

use DrdPlus\Tables\AbstractMeasurement;
use DrdPlus\Tables\Exceptions\UnknownUnit;
use Granam\Float\Tools\ToFloat;
use Granam\Scalar\Tools\ValueDescriber;

class DistanceMeasurement extends AbstractMeasurement
{
    const M = 'm';
    const KM = 'km';
    const LIGHT_YEAR = 'light_year';

    /**
     * @param float $value
     * @param string $unit
     */
    public function __construct($value, $unit)
    {
        parent::__construct($value, $unit);
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits()
    {
        return [self::M, self::KM, self::LIGHT_YEAR];
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkValueInDifferentUnit($value, $unit);
        $inOriginalUnit = $this->toDifferentUnit($value, $unit, $this->getUnit());
        if ($inOriginalUnit !== $this->getValue()) {
            throw new Exceptions\IncorrectRatio(
                "Every another expression in another unit has to equal to original measure after conversion."
                . " Expected equation to {$this->getValue()}({$this->getUnit()}), got $value($unit) converted into"
                . " $inOriginalUnit({$this->getUnit()})"
            );
        }
        // distance conversion is always known, there is no reason to keep the "another" measure
    }

    public function toMeters()
    {
        return $this->toDifferentUnit($this->getValue(), $this->getUnit(), self::M);
    }

    private function toDifferentUnit($value, $fromUnit, $toUnit)
    {
        if ($fromUnit === $toUnit) {
            return ToFloat::toFloat($value);
        }
        if ($fromUnit === self::M && $toUnit === self::KM) {
            return $value / 1000;
        }
        if ($fromUnit === self::KM && $toUnit === self::M) {
            return $value * 1000;
        }
        throw new UnknownUnit(
            'Unknown one or both from ' . ValueDescriber::describe($fromUnit) . ' to ' . ValueDescriber::describe($toUnit) . ' unit'
        );
    }

    public function toKilometers()
    {
        return $this->toDifferentUnit($this->getValue(), $this->getUnit(), self::KM);
    }
}
