<?php
namespace DrdPlus\Tables\Distance;
use DrdPlus\Tables\AbstractTable;
use DrdPlus\Tables\DummyEvaluator;

/**
 * PPH page 162, top
 * @method DistanceMeasurement toMeasurement($bonus, $unit = null)
 */
class DistanceTable extends AbstractTable
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
        return [DistanceMeasurement::M, DistanceMeasurement::KM, DistanceMeasurement::LIGHT_YEAR];
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toMeters($bonus)
    {
        return $this->toMeasurement($bonus)->toMeters();
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toKilometers($bonus)
    {
        return $this->toMeasurement($bonus)->toKilometers();
    }

    public function kilometersToBonus($km)
    {
        return $this->toBonus(new DistanceMeasurement($km, DistanceMeasurement::KM));
    }

    public function metersToBonus($m)
    {
        return $this->toBonus(new DistanceMeasurement($m, DistanceMeasurement::M));
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return DistanceMeasurement
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new DistanceMeasurement($value, $unit);
    }

}
