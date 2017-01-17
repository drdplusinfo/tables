<?php
namespace DrdPlus\Tables\Measurements\Distance;

use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Float\Tools\ToFloat;
use Granam\Tools\ValueDescriber;

class Distance extends AbstractMeasurementWithBonus
{
    const M = 'm';
    const KM = 'km';
    const LIGHT_YEAR = 'light_year';

    /**
     * @var DistanceTable
     */
    private $distanceTable;

    /**
     * @param float $value
     * @param string $unit
     * @param DistanceTable $distanceTable
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function __construct($value, $unit, DistanceTable $distanceTable)
    {
        $this->distanceTable = $distanceTable;
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
     * @return DistanceBonus
     */
    public function getBonus()
    {
        return $this->distanceTable->toBonus($this);
    }

    /**
     * @return float
     */
    public function getMeters()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit($this->getValue(), $this->getUnit(), self::M);
    }

    /**
     * @param $value
     * @param $fromUnit
     * @param $toUnit
     * @return float
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    private function getValueInDifferentUnit($value, $fromUnit, $toUnit)
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
            'Unknown one or both from ' . ValueDescriber::describe($fromUnit)
            . ' to ' . ValueDescriber::describe($toUnit) . ' unit(s)'
        );
    }

    /**
     * @return float
     */
    public function getKilometers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit($this->getValue(), $this->getUnit(), self::KM);
    }

    /**
     * @return float
     */
    public function getLightYears()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit($this->getValue(), $this->getUnit(), self::LIGHT_YEAR);
    }

}