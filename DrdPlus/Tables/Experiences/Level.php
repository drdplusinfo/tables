<?php
namespace DrdPlus\Tables\Experiences;

class Level extends AbstractExperiencesMeasurement
{
    const LEVEL = 'level';

    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    public function __construct($value, $unit, ExperiencesTable $experiencesTable)
    {
        parent::__construct($value, $unit);
        $this->experiencesTable = $experiencesTable;
    }

    public function getPossibleUnits()
    {
        return [self::LEVEL];
    }

    /**
     * @return Experiences
     */
    public function getExperiences()
    {
        return $this->experiencesTable->levelToExperiences($this);
    }

    /**
     * Summary of experiences, needed to achieve current level
     *
     * @return Experiences
     */
    public function getTotalExperiences()
    {
        return $this->experiencesTable->levelToTotalExperiences($this);
    }

    /**
     * @return ExperiencesBonus
     */
    public function getBonus()
    {
        return $this->getExperiences()->getBonus();
    }

}
