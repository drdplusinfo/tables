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
     * @return Time
     */
    public function getTime($wantedUnit = null)
    {
        return $this->timeTable->toTime($this, $wantedUnit);
    }

}
