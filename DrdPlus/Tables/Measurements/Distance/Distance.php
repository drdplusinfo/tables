<?php
namespace DrdPlus\Tables\Measurements\Distance;

use DrdPlus\Codes\DistanceCode;
use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Float\Tools\ToFloat;
use Granam\Tools\ValueDescriber;

class Distance extends AbstractMeasurementWithBonus
{
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
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct($value, $unit, DistanceTable $distanceTable)
    {
        $this->distanceTable = $distanceTable;
        parent::__construct($value, $unit);
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits(): array
    {
        return [DistanceCode::M, DistanceCode::KM, DistanceCode::LIGHT_YEAR];
    }

    /**
     * @return DistanceBonus
     */
    public function getBonus(): DistanceBonus
    {
        return $this->distanceTable->toBonus($this);
    }

    /**
     * @return float
     */
    public function getMeters(): float
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit($this->getValue(), $this->getUnit(), DistanceCode::M);
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
    private function getValueInDifferentUnit($value, $fromUnit, $toUnit): float
    {
        if ($fromUnit === $toUnit) {
            return ToFloat::toFloat($value);
        }
        if ($fromUnit === DistanceCode::M && $toUnit === DistanceCode::KM) {
            return $value / 1000;
        }
        if ($fromUnit === DistanceCode::KM && $toUnit === DistanceCode::M) {
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
    public function getKilometers(): float
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit($this->getValue(), $this->getUnit(), DistanceCode::KM);
    }

    /**
     * @return float
     */
    public function getLightYears(): float
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit($this->getValue(), $this->getUnit(), DistanceCode::LIGHT_YEAR);
    }

}