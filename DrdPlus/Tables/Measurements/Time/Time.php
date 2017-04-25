<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Codes\TimeUnitCode;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurement;
use Granam\Integer\Tools\ToInteger;
use Granam\Scalar\Tools\ToString;
use Granam\String\StringInterface;
use Granam\Tools\ValueDescriber;

class Time extends AbstractMeasurement implements MeasurementWithBonus
{
    const HOURS_PER_DAY = 12.0;

    const ROUND = TimeUnitCode::ROUND;
    const MINUTE = TimeUnitCode::MINUTE;
    const HOUR = TimeUnitCode::HOUR;
    const DAY = TimeUnitCode::DAY;
    const MONTH = TimeUnitCode::MONTH;
    const YEAR = TimeUnitCode::YEAR;

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
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct($value, $unit);
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        if ($this->getUnit() === TimeUnitCode::ROUND) {
            // only rounds are always integer
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return ToInteger::toInteger(parent::getValue());
        }

        return parent::getValue();
    }

    /**
     * @return TimeUnitCode
     */
    public function getUnitCode(): TimeUnitCode
    {
        return TimeUnitCode::getIt($this->getUnit());
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits(): array
    {
        return [TimeUnitCode::ROUND, TimeUnitCode::MINUTE, TimeUnitCode::HOUR, TimeUnitCode::DAY, TimeUnitCode::MONTH, TimeUnitCode::YEAR];
    }

    /**
     * @return TimeBonus
     */
    public function getBonus(): TimeBonus
    {
        return $this->timeTable->toBonus($this);
    }

    /**
     * @return Time|null
     */
    public function findRounds()
    {
        return $this->findIn(TimeUnitCode::ROUND);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getRounds(): Time
    {
        return $this->getInUnit(TimeUnitCode::ROUND);
    }

    /**
     * @param string|StringInterface $unit
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getInUnit($unit): Time
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
     * @param string|StringInterface $unit
     * @return Time|null
     */
    public function findIn($unit)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        if (ToString::toString($unit) === $this->getUnit()) {
            return clone $this;
        }
        $bonus = $this->timeTable->toBonus($this);

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->timeTable->hasTimeFor($bonus, $unit)
            ? $this->timeTable->toTime($bonus, $unit)
            : null;
    }

    /**
     * @return Time|null
     */
    public function findMinutes()
    {
        return $this->findIn(TimeUnitCode::MINUTE);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getMinutes(): Time
    {
        return $this->getInUnit(TimeUnitCode::MINUTE);
    }

    /**
     * @return Time|null
     */
    public function findHours()
    {
        return $this->findIn(TimeUnitCode::HOUR);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getHours(): Time
    {
        return $this->getInUnit(TimeUnitCode::HOUR);
    }

    /**
     * @return Time|null
     */
    public function findDays()
    {
        return $this->findIn(TimeUnitCode::DAY);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getDays(): Time
    {
        return $this->getInUnit(TimeUnitCode::DAY);
    }

    /**
     * @return Time|null
     */
    public function findMonths()
    {
        return $this->findIn(TimeUnitCode::MONTH);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getMonths(): Time
    {
        return $this->getInUnit(TimeUnitCode::MONTH);
    }

    /**
     * @return Time|null
     */
    public function findYears()
    {
        return $this->findIn(TimeUnitCode::YEAR);
    }

    /**
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function getYears(): Time
    {
        return $this->getInUnit(TimeUnitCode::YEAR);
    }

}