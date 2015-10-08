<?php
namespace DrdPlus\Tables\Measurements\Experiences;

use DrdPlus\Tables\Measurements\Parts\AbstractBonus;

class Level extends AbstractBonus
{
    const LEVEL = 'level';
    const MAX_LEVEL = 20;

    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    public function __construct($value, ExperiencesTable $experiencesTable)
    {
        parent::__construct($value);
        $this->checkMaxLevel($this->getValue());
        $this->experiencesTable = $experiencesTable;
    }

    private function checkMaxLevel($levelValue)
    {
        // level is not limited by table values, so has to be in code
        if ($levelValue > static::MAX_LEVEL) {
            throw new Exceptions\MaxLevelOverflow("Level can not be greater than " . self::MAX_LEVEL);
        }
    }

    /**
     * @return Experiences
     */
    public function getExperiences()
    {
        return $this->experiencesTable->toExperiences($this);
    }

    /**
     * Summary of experiences, needed to achieve current level
     *
     * @param bool $isMainProfession
     *
     * @return Experiences
     */
    public function getTotalExperiences($isMainProfession)
    {
        return $this->experiencesTable->toTotalExperiences($this, $isMainProfession);
    }

}
