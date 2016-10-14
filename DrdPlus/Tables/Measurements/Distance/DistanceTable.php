<?php
namespace DrdPlus\Tables\Measurements\Distance;

use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;

/**
 * PPH page 162, top
 */
class DistanceTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/distance.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Distance::M, Distance::KM, Distance::LIGHT_YEAR];
    }

    /**
     * @param DistanceBonus $distanceBonus
     *
     * @return Distance
     */
    public function toDistance(DistanceBonus $distanceBonus)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($distanceBonus);
    }

    /**
     * @param Distance $distance
     * @return DistanceBonus
     */
    public function toBonus(Distance $distance)
    {
        return $this->measurementToBonus($distance);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Distance
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Distance($value, $unit, $this);
    }

    /**
     * @param int $bonusValue
     *
     * @return DistanceBonus
     */
    protected function createBonus($bonusValue)
    {
        return new DistanceBonus($bonusValue, $this);
    }

    /**
     * @param IntegerInterface|int $size
     * @return DistanceBonus
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function sizeToDistanceBonus($size)
    {
        return $this->createBonus(ToInteger::toInteger($size) + 12);
    }

}
