<?php
namespace DrdPlus\Tables\BonusBased\Speed;
use DrdPlus\Tables\AbstractTable;
use DrdPlus\Tables\DummyEvaluator;

/**
 * PPH page 163
 * @method SpeedMeasurement toMeasurement($bonus, $unit = null)
 */
class SpeedTable extends AbstractTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/speed.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [SpeedMeasurement::M_PER_ROUND, SpeedMeasurement::KM_PER_HOUR];
    }

    public function kmPerHourToBonus($kmPerHour)
    {
        return $this->toBonus(new SpeedMeasurement($kmPerHour, SpeedMeasurement::KM_PER_HOUR));
    }

    public function mPerRoundToBonus($mPerRound)
    {
        return $this->toBonus(new SpeedMeasurement($mPerRound, SpeedMeasurement::M_PER_ROUND));
    }

    public function toMetersPerRound($bonus)
    {
        return $this->toMeasurement($bonus, SpeedMeasurement::M_PER_ROUND)->toMetersPerRound();
    }

    public function toKilometersPerHour($bonus)
    {
        return $this->toMeasurement($bonus, SpeedMeasurement::KM_PER_HOUR)->toKilometersPerHour();
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return SpeedMeasurement
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new SpeedMeasurement($value, $unit);
    }

}
