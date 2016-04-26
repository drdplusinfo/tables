<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;

/**
 * PPH, page 161
 */
class TimeTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/time.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Time::ROUND, Time::MINUTE, Time::HOUR, Time::DAY, Time::MONTH, Time::YEAR];
    }

    /**
     * @param TimeBonus $timeBonus
     * @param string|null $wantedUnit
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnexpectedChangeNotation
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
        return $this->hasValueByBonusAndUnit($timeBonus, $wantedUnit);
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
