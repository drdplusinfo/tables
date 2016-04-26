<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurement;
use Granam\Integer\Tools\ToInteger;
use Granam\Tools\ValueDescriber;

class Time extends AbstractMeasurement implements MeasurementWithBonus
{

    const ROUND = 'round';
    const MINUTE = 'minute';
    const HOUR = 'hour';
    const DAY = 'day';
    const MONTH = 'month';
    const YEAR = 'year';

    const HOURS_PER_DAY = 12.0;

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
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getValue()
    {
        if ($this->getUnit() === self::ROUND) {
            // only rounds are always integer
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
     * @return Time|null
     */
    public function findRounds()
    {
        return $this->findIn(self::ROUND);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getRounds()
    {
        return $this->getIn(self::ROUND);
    }

    /**
     * @param string $unit
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getIn($unit)
    {
        $inDifferentUnit = $this->findIn($unit);
        if ($inDifferentUnit !== null) {
            return $inDifferentUnit;
        }
        throw new Exceptions\CanNotConvertTimeToUnit(
            'Can not convert ' . $this->getValue() . ' ' . $this->getUnit() . '(s)'
            . ' into ' . ValueDescriber::describe($unit)
        );
    }

    /**
     * @param string $unit
     * @return Time|null
     */
    public function findIn($unit)
    {
        if ($unit === $this->getUnit()) {
            return clone $this;
        }
        $bonus = $this->timeTable->toBonus($this);

        return $this->timeTable->hasTimeFor($bonus, $unit)
            ? $this->timeTable->toTime($bonus, $unit)
            : null;
    }

    /**
     * @return Time|null
     */
    public function findMinutes()
    {
        return $this->findIn(self::MINUTE);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getMinutes()
    {
        return $this->getIn(self::MINUTE);
    }

    /**
     * @return Time|null
     */
    public function findHours()
    {
        return $this->findIn(self::HOUR);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getHours()
    {
        return $this->getIn(self::HOUR);
    }

    /**
     * @return Time|null
     */
    public function findDays()
    {
        return $this->findIn(self::DAY);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getDays()
    {
        return $this->getIn(self::DAY);
    }

    /**
     * @return Time|null
     */
    public function findMonths()
    {
        return $this->findIn(self::MONTH);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getMonths()
    {
        return $this->getIn(self::MONTH);
    }

    /**
     * @return Time|null
     */
    public function findYears()
    {
        return $this->findIn(self::YEAR);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getYears()
    {
        return $this->getIn(self::YEAR);
    }

}
