<?php
namespace DrdPlus\Tables\Derived\Experiences;

class LevelMeasurement extends AbstractExperiencesMeasurement
{
    const LEVEL = 'level';

    /**
     * @param int $value
     * @param ExperiencesTable $experiencesTable
     *
     * @return static
     */
    public static function getIt($value, ExperiencesTable $experiencesTable)
    {
        return new static($value, static::LEVEL, $experiencesTable);
    }

    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    public function __construct($value, $unit = self::LEVEL, ExperiencesTable $experiencesTable)
    {
        parent::__construct($value, $unit);
        $this->experiencesTable = $experiencesTable;
    }

    public function getPossibleUnits()
    {
        return [self::LEVEL];
    }

    /**
     * @return int
     */
    public function toLevel()
    {
        return $this->getValue();
    }

    /**
     * @return int
     */
    public function toExperiences()
    {
        return $this->experiencesTable->levelToExperiences($this->getValue());
    }

    /**
     * Summary of experiences, needed to achieve current level
     *
     * @return int
     */
    public function toTotalExperiences()
    {
        return $this->experiencesTable->levelToTotalExperiences($this->getValue());
    }

}
