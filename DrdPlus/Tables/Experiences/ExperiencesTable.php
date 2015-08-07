<?php
namespace DrdPlus\Tables\Experiences;

use DrdPlus\Tables\Exceptions\UnknownUnit;
use DrdPlus\Tables\MeasurementInterface;
use DrdPlus\Tables\TableInterface;
use DrdPlus\Tables\Wounds\WoundsTable;
use Granam\Scalar\Tools\ValueDescriber;
use Granam\Strict\Object\StrictObject;

/**
 * PPH page 44, top right
 */
class ExperiencesTable extends StrictObject implements TableInterface
{
    /** @var \DrdPlus\Tables\Wounds\WoundsTable */
    private $woundsTable;

    public function __construct(WoundsTable $woundsTable)
    {
        // experiences has the very same conversions as wounds have
        $this->woundsTable = $woundsTable;
    }

    /**
     * @param MeasurementInterface $measurement
     *
     * @return int
     */
    public function toBonus(MeasurementInterface $measurement)
    {
        $experiencesValue = null;
        switch ($measurement->getUnit()) {
            case ExperiencesMeasurement::EXPERIENCES :
                /** @var ExperiencesMeasurement $measurement */
                $experiencesValue = $measurement->getValue();

                return $this->woundsTable->woundsToBonus($experiencesValue);
            case LevelMeasurement::LEVEL :
                /** @var LevelMeasurement $measurement */
                $levelBonus = $this->woundsTable->woundsToBonus($measurement->getValue());

                return $levelBonus + 15;
            default :
                throw new UnknownUnit("Unknown unit {$measurement->getUnit()}");
        }
    }

    /**
     * @param int $experiencesBonus
     * @param string $toUnit
     *
     * @return ExperiencesMeasurement|LevelMeasurement
     */
    public function toMeasurement($experiencesBonus, $toUnit)
    {
        switch ($toUnit) {
            case ExperiencesMeasurement::EXPERIENCES :
                return $this->toExperiencesMeasurement($experiencesBonus);
            case LevelMeasurement::LEVEL :
                return $this->toLevelMeasurement($experiencesBonus);
            default :
                throw new UnknownUnit('Unknown unit ' . ValueDescriber::describe($toUnit));
        }
    }

    /**
     * @param int $experiencesBonus
     *
     * @return ExperiencesMeasurement
     */
    public function toExperiencesMeasurement($experiencesBonus)
    {
        return ExperiencesMeasurement::getIt($this->toExperiences($experiencesBonus), $this);
    }

    /**
     * @param int $experiencesBonus
     *
     * @return LevelMeasurement
     */
    public function toLevelMeasurement($experiencesBonus)
    {
        return LevelMeasurement::getIt($this->toLevel($experiencesBonus), $this);
    }

    /**
     * @param int $experiencesBonus
     *
     * @return int
     */
    public function toExperiences($experiencesBonus)
    {
        return $this->woundsTable->toWounds($experiencesBonus);
    }

    /**
     * @param int $experiencesBonus
     *
     * @return int
     */
    public function toLevel($experiencesBonus)
    {
        $levelBonus = $experiencesBonus - 15;
        $woundsAsLevel = $this->woundsTable->toWounds($levelBonus);

        return $woundsAsLevel;
    }

    /**
     * @param int $experiencesValue
     *
     * @return int
     */
    public function experiencesToLevel($experiencesValue)
    {
        $experiencesBonus = $this->experiencesToBonus($experiencesValue);

        return $this->toLevel($experiencesBonus);
    }

    /**
     * @param int $amount
     *
     * @return int
     */
    private function experiencesToBonus($amount)
    {
        return $this->woundsTable->woundsToBonus($amount);
    }

    /**
     * @param int $levelValue
     *
     * @return int
     */
    public function levelToExperiences($levelValue)
    {
        $experiencesBonus = $this->levelToExperiencesBonus($levelValue);

        return $this->toExperiences($experiencesBonus);
    }

    /**
     * @param int $level
     *
     * @return int
     */
    private function levelToExperiencesBonus($level)
    {
        return $level + 15;
    }

    /**
     * @param int $level
     *
     * @return int
     */
    public function levelToTotalExperiences($level)
    {
        $experiencesSum = 0;
        for ($levelToCast = $level; $levelToCast > 0; $levelToCast--) {
            $experiencesSum += $this->levelToExperiences($levelToCast);
        }

        return $experiencesSum;
    }

    /**
     * @param int $experiences
     *
     * @return int
     */
    public function experiencesToTotalLevel($experiences)
    {
        $levelSum = 0;
        $lastUsedLevel = 0;
        for ($experiencesToCast = 1; $experiencesToCast < $experiences; $experiencesToCast++) {
            $level = $this->experiencesToLevel($experiencesToCast);
            if ($level > $lastUsedLevel) {
                $levelSum += $level;
                $lastUsedLevel = $level;
            }
        }

        return $levelSum;
    }

}
