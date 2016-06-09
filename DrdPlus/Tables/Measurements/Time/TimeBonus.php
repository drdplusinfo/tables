<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

class TimeBonus extends AbstractBonus
{
    /**
     * @var TimeTable
     */
    private $timeTable;

    /**
     * @param int $value
     * @param TimeTable $timeTable
     */
    public function __construct($value, TimeTable $timeTable)
    {
        parent::__construct($value);
        $this->timeTable = $timeTable;
    }

    /**
     * @param string|null $wantedUnit
     * @return Time|null
     */
    public function findTime($wantedUnit = null)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->timeTable->hasTimeFor($this, $wantedUnit)
            ? $this->timeTable->toTime($this, $wantedUnit)
            : null;
    }

    /**
     * @param string|null $wantedUnit
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertThatBonusToTime
     */
    public function getTime($wantedUnit = null)
    {
        $time = $this->findTime($wantedUnit);
        if ($time !== null) {
            return $time;
        }
        throw new Exceptions\CanNotConvertThatBonusToTime(
            'Can not convert time bonus ' . $this->getValue() . ' into time with unit '
            . ($wantedUnit !== null ? $wantedUnit : '"any possible"')
        );
    }

}
