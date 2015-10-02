<?php
namespace DrdPlus\Tables\Experiences;

class Experiences extends AbstractExperiencesMeasurement
{
    const EXPERIENCES = 'experiences';

    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    public function __construct($value, $unit, ExperiencesTable $experiencesTable)
    {
        parent::__construct($value, $unit);
        $this->experiencesTable = $experiencesTable;
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits()
    {
        return [self::EXPERIENCES];
    }

    /**
     * @return Level
     */
    public function getLevel()
    {
        return $this->experiencesTable->experiencesToLevel($this);
    }

    /**
     * Final level, achieved by sparing current experiences from total zero
     *
     * @return Level
     */
    public function getTotalLevel()
    {
        return $this->experiencesTable->experiencesToTotalLevel($this);
    }

    /**
     * @return ExperiencesBonus
     */
    public function getBonus()
    {
        return $this->experiencesTable->experiencesToBonus($this);
    }

}
