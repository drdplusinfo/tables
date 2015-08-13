<?php
namespace DrdPlus\Tables\Base\Time;

use DrdPlus\Tables\AbstractTable;
use DrdPlus\Tables\DummyEvaluator;

/**
 * @method TimeMeasurement toMeasurement($bonus, $unit)
 */
class TimeTable extends AbstractTable
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
        return [TimeMeasurement::ROUND, TimeMeasurement::MINUTE, TimeMeasurement::HOUR, TimeMeasurement::DAY, TimeMeasurement::MONTH, TimeMeasurement::YEAR];
    }

    /**
     * @param int $bonus
     *
     * @return int
     */
    public function toRounds($bonus)
    {
        return (int)$this->toMeasurement($bonus, TimeMeasurement::ROUND)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function roundsToBonus($amount)
    {
        return $this->toBonus(new TimeMeasurement($amount, TimeMeasurement::ROUND));
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toMinutes($bonus)
    {
        return (int)$this->toMeasurement($bonus, TimeMeasurement::MINUTE)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function minutesToBonus($amount)
    {
        return $this->toBonus(new TimeMeasurement($amount, TimeMeasurement::MINUTE));
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toHours($bonus)
    {
        return $this->toMeasurement($bonus, TimeMeasurement::HOUR)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function hoursToBonus($amount)
    {
        return $this->toBonus(new TimeMeasurement($amount, TimeMeasurement::HOUR));
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toDays($bonus)
    {
        return $this->toMeasurement($bonus, TimeMeasurement::DAY)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function daysToBonus($amount)
    {
        return $this->toBonus(new TimeMeasurement($amount, TimeMeasurement::DAY));
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toMonths($bonus)
    {
        return $this->toMeasurement($bonus, TimeMeasurement::MONTH)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function monthsToBonus($amount)
    {
        return $this->toBonus(new TimeMeasurement($amount, TimeMeasurement::MONTH));
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toYears($bonus)
    {
        return $this->toMeasurement($bonus, TimeMeasurement::YEAR)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function yearsToBonus($amount)
    {
        return $this->toBonus(new TimeMeasurement($amount, TimeMeasurement::YEAR));
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return TimeMeasurement
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new TimeMeasurement($value, $unit);
    }

}
