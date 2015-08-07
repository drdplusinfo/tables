<?php
namespace DrdPlus\Tables\Experiences;

class ExperiencesMeasurement extends AbstractExperiencesMeasurement
{
    const EXPERIENCES = 'experiences';

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
        parent::__construct($value, $unit);
        $this->experiencesTable = $experiencesTable;
    }

    public function getPossibleUnits()
    {
        return [self::EXPERIENCES];
    }

    /**
     * @return int
     */
    public function toLevel()
    {
        return $this->experiencesTable->experiencesToLevel($this->getValue());
    }

    /**
     * @return int
     */
    public function toExperiences()
    {
        return $this->getValue();
    }

    /**
     * Final level, achieved by sparing current experiences from total zero
     *
     * @return int
     */
    public function toTotalLevel()
    {
        return $this->experiencesTable->experiencesToTotalLevel($this->getValue());
    }

}
