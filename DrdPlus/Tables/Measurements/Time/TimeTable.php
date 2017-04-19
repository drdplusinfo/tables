<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Codes\TimeCode;
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
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/time.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeader(): array
    {
        return [TimeCode::ROUND, TimeCode::MINUTE, TimeCode::HOUR, TimeCode::DAY, TimeCode::MONTH, TimeCode::YEAR];
    }

    /**
     * @param TimeBonus $timeBonus
     * @param string|null $wantedUnit
     * @return Time|MeasurementWithBonus
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnexpectedChanceNotation
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    public function toTime(TimeBonus $timeBonus, $wantedUnit = null): Time
    {
        return $this->toMeasurement($timeBonus, $wantedUnit);
    }

    /**
     * @param TimeBonus $timeBonus
     * @param null $wantedUnit
     * @return bool
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    public function hasTimeFor(TimeBonus $timeBonus, $wantedUnit = null): bool
    {
        return $this->hasMeasurementFor($timeBonus, $wantedUnit);
    }

    /**
     * @param Time $time
     * @return TimeBonus|AbstractBonus
     */
    public function toBonus(Time $time): TimeBonus
    {
        return $this->measurementToBonus($time);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return Time
     */
    protected function convertToMeasurement($value, $unit): Time
    {
        return new Time($value, $unit, $this);
    }

    /**
     * @param int $bonusValue
     * @return TimeBonus
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    protected function createBonus($bonusValue): TimeBonus
    {
        return new TimeBonus($bonusValue, $this);
    }

}