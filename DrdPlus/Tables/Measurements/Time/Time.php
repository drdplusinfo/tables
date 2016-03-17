<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Parts\AbstractMeasurement;
use Granam\Integer\Tools\ToInteger;

class Time extends AbstractMeasurement implements MeasurementWithBonus
{

    const ROUND = 'round';
    const MINUTE = 'minute';
    const HOUR = 'hour';
    const DAY = 'day';
    const MONTH = 'month';
    const YEAR = 'year';

    /**
     * @var TimeTable
     */
    private $timeTable;

    /**
     * @param float $value
     * @param TimeTable $timeTable
     * @param string $unit
     */
    public function __construct($value, $unit, TimeTable $timeTable)
    {
        $this->timeTable = $timeTable;
        parent::__construct($value, $unit);
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        if ($this->getUnit() === self::ROUND) {
            return ToInteger::toInteger(parent::getValue());
        }

        return parent::getValue();
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits()
    {
        return [self::ROUND, self::MINUTE, self::HOUR, self::DAY, self::MONTH, self::YEAR];
    }

    /**
     * @return TimeBonus
     */
    public function getBonus()
    {
        return $this->timeTable->toBonus($this);
    }

    /**
     * @return Time
     */
    public function getRounds()
    {
        return $this->getInDifferentUnit(self::ROUND);
    }

    /**
     * @param string $unit
     *
     * @return Time
     */
    private function getInDifferentUnit($unit)
    {
        if ($unit === $this->getUnit()) {
            return clone $this;
        }
        $bonus = $this->timeTable->toBonus($this);

        return $this->timeTable->toTime($bonus, $unit);
    }

    /**
     * @return Time
     */
    public function getMinutes()
    {
        return $this->getInDifferentUnit(self::MINUTE);
    }

    /**
     * @return Time
     */
    public function getHours()
    {
        return $this->getInDifferentUnit(self::HOUR);
    }

    /**
     * @return Time
     */
    public function getDays()
    {
        return $this->getInDifferentUnit(self::DAY);
    }

    /**
     * @return Time
     */
    public function getMonths()
    {
        return $this->getInDifferentUnit(self::MONTH);
    }

    /**
     * @return Time
     */
    public function getYears()
    {
        return $this->getInDifferentUnit(self::YEAR);
    }

}
