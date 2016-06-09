<?php
namespace DrdPlus\Tables\Measurements\Speed;

use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;

/**
 * PPH page 163
 */
class SpeedTable extends AbstractMeasurementFileTable
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
        return [Speed::M_PER_ROUND, Speed::KM_PER_HOUR];
    }

    /**
     * @param float $bonusValue
     *
     * @return SpeedBonus
     */
    protected function createBonus($bonusValue)
    {
        return new SpeedBonus($bonusValue, $this);
    }

    /**
     * @param SpeedBonus $bonus
     * @param string|null $wantedUnit
     *
     * @return Speed
     */
    public function toSpeed(SpeedBonus $bonus, $wantedUnit = null)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($bonus, $wantedUnit);
    }

    /**
     * @param Speed $speed
     * @return SpeedBonus
     */
    public function toBonus(Speed $speed)
    {
        return $this->measurementToBonus($speed);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Speed
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Speed($value, $unit, $this);
    }

}
