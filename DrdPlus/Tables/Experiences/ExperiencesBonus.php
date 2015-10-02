<?php
namespace DrdPlus\Tables\Experiences;

use DrdPlus\Tables\Parts\AbstractBonus;

class ExperiencesBonus extends AbstractBonus
{
    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    /**
     * @param int $bonusValue
     * @param ExperiencesTable $experiencesTable
     */
    public function __construct($bonusValue, ExperiencesTable $experiencesTable)
    {
        parent::__construct($bonusValue);
        $this->experiencesTable = $experiencesTable;
    }

    /**
     * @return Experiences
     */
    public function getExperiences()
    {
        return $this->experiencesTable->toExperiences($this);
    }

    /**
     * @return Level
     */
    public function getLevel()
    {
        return $this->experiencesTable->toLevel($this);
    }
}
