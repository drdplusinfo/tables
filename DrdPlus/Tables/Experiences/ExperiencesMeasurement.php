<?php
namespace DrdPlus\Tables\Experiences;

class ExperiencesMeasurement extends AbstractExperiencesMeasurement
{
    const EXPERIENCES = 'experiences';

    const EXPERIENCES_TO_LEVEL_BONUS_SHIFT = 15;

    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    /**
     * @param int $value
     * @param ExperiencesTable $experiencesTable
     *
     * @return static
     */
    public static function getIt($value, ExperiencesTable $experiencesTable)
    {
        return new static($value, static::EXPERIENCES, $experiencesTable);
    }

    public function __construct($value, $unit = self::EXPERIENCES, ExperiencesTable $experiencesTable)
    {
        $this->experiencesTable = $experiencesTable;
        parent::__construct($value, $unit);
    }

    public function getPossibleUnits()
    {
        return [self::EXPERIENCES];
    }

    /**
     * @return int
     */
    public function toExperiences()
    {
        return $this->getValue();
    }

    /**
     * @return int
     */
    public function toLevel()
    {
        $bonus = $this->experiencesTable->experiencesToBonus($this->getValue());

        return $this->experiencesTable->toExperiences($bonus + self::EXPERIENCES_TO_LEVEL_BONUS_SHIFT);
    }

    /**
     * Final level, achieved by sparing current experiences from total zero
     *
     * @return int
     */
    public function toTotalLevel()
    {
        $totalLevel = 0;
        $usedExperience = 0;
        for ($currentExperience = 0; ($currentExperience + $usedExperience) <= $this->toExperiences(); $currentExperience++) {
            $bonus = $this->experiencesTable->experiencesToBonus($currentExperience);
            $level = $this->experiencesTable->toLevel($bonus);
            if ($level > $totalLevel) {
                $totalLevel = $level;
                $usedExperience += $currentExperience;
            }
        }
    }

}
