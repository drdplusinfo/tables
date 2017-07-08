<?php
namespace DrdPlus\Tables\Measurements\Distance;

use DrdPlus\Codes\Units\DistanceUnitCode;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;

/**
 * See PPH page 162 top, @link https://pph.drdplus.info/#tabulka_vzdalenosti
 */
class DistanceTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/distance.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeader(): array
    {
        return [DistanceUnitCode::METER, DistanceUnitCode::KILOMETER, DistanceUnitCode::LIGHT_YEAR];
    }

    /**
     * @param DistanceBonus $distanceBonus
     * @return Distance|MeasurementWithBonus
     */
    public function toDistance(DistanceBonus $distanceBonus)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($distanceBonus);
    }

    /**
     * @param Distance $distance
     * @return DistanceBonus|AbstractBonus
     */
    public function toBonus(Distance $distance)
    {
        return $this->measurementToBonus($distance);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return Distance
     */
    protected function convertToMeasurement($value, $unit): Distance
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new Distance($value, $unit, $this);
    }

    /**
     * @param int $bonusValue
     * @return DistanceBonus
     */
    protected function createBonus($bonusValue): DistanceBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new DistanceBonus($bonusValue, $this);
    }

    /**
     * @param IntegerInterface|int $size
     * @return DistanceBonus
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function sizeToDistanceBonus($size): DistanceBonus
    {
        return $this->createBonus(ToInteger::toInteger($size) + 12);
    }

}
