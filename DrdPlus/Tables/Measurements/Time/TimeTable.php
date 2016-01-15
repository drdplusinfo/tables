<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Parts\AbstractFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;

/**
 * PPH, page 161
 */
class TimeTable extends AbstractFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/time.csv';
    }

    protected function getExpectedColumnsHeader()
    {
        return [Time::ROUND, Time::MINUTE, Time::HOUR, Time::DAY, Time::MONTH, Time::YEAR];
    }

    /**
     * @param TimeBonus $timeBonus
     * @param string|null $wantedUnit
     *
     * @return Time
     */
    public function toTime(TimeBonus $timeBonus, $wantedUnit = null)
    {
        return $this->toMeasurement($timeBonus, $wantedUnit);
    }

    /**
     * @param Time $time
     * @return TimeBonus
     */
    public function toBonus(Time $time)
    {
        return $this->measurementToBonus($time);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Time
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Time($value, $unit, $this);
    }

    /**
     * @param int $bonusValue
     *
     * @return TimeBonus
     */
    protected function createBonus($bonusValue)
    {
        return new TimeBonus($bonusValue, $this);
    }

}
