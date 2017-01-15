<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;

/**
 * See PPH page 161, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_rychlosti
 */
class TimeTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/time.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeader()
    {
        return [Time::ROUND, Time::MINUTE, Time::HOUR, Time::DAY, Time::MONTH, Time::YEAR];
    }

    /**
     * @param TimeBonus $timeBonus
     * @param string|null $wantedUnit
     * @return Time|MeasurementWithBonus
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnexpectedChanceNotation
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    public function toTime(TimeBonus $timeBonus, $wantedUnit = null)
    {
        return $this->toMeasurement($timeBonus, $wantedUnit);
    }

    /**
     * @param TimeBonus $timeBonus
     * @param null $wantedUnit
     * @return true
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    public function hasTimeFor(TimeBonus $timeBonus, $wantedUnit = null)
    {
        return $this->hasMeasurementFor($timeBonus, $wantedUnit);
    }

    /**
     * @param Time $time
     * @return TimeBonus|AbstractBonus
     */
    public function toBonus(Time $time)
    {
        return $this->measurementToBonus($time);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return Time
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Time($value, $unit, $this);
    }

    /**
     * @param int $bonusValue
     * @return TimeBonus
     */
    protected function createBonus($bonusValue)
    {
        return new TimeBonus($bonusValue, $this);
    }

}