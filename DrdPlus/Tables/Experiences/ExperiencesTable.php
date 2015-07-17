<?php
namespace DrdPlus\Tables\Experiences;

use DrdPlus\Tables\MeasurementInterface;
use DrdPlus\Tables\TableInterface;
use DrdPlus\Tables\Wounds\WoundsMeasurement;
use DrdPlus\Tables\Wounds\WoundsTable;
use Granam\Integer\Tools\ToInteger;
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
     * @param MeasurementInterface $experiencesMeasurement
     *
     * @return int
     */
    public function toBonus(MeasurementInterface $experiencesMeasurement)
    {
        $this->checkUnit($experiencesMeasurement->getUnit());
        $experiencesValue = null;
        switch ($experiencesMeasurement->getUnit()) {
            case ExperiencesMeasurement::EXPERIENCES :
                $experiencesValue = $experiencesMeasurement->getValue();
                break;
            case LevelMeasurement::LEVEL :
                /** @var LevelMeasurement $experiencesMeasurement */
                $experiencesValue = $experiencesMeasurement->toExperiences();
                break;
            default :
                throw new \LogicException("Unknown unit {$experiencesMeasurement->getUnit()}");
        }

        return $this->woundsTable->woundsToBonus($experiencesValue);
    }

    private function checkUnit($unit)
    {
        if (!in_array($unit, $this->getSupportedUnits())) {
            throw new \LogicException(
                'Expected one of ' . implode(',', $this->getSupportedUnits()) . ", got $unit"
            );
        }
    }

    private function getSupportedUnits()
    {
        return [ExperiencesMeasurement::EXPERIENCES, LevelMeasurement::LEVEL];
    }

    /**
     * @param int $bonus
     * @param string $unit
     *
     * @return ExperiencesMeasurement|LevelMeasurement
     */
    public function toMeasurement($bonus, $unit = ExperiencesMeasurement::EXPERIENCES)
    {
        $this->checkUnit($unit);
        $wounds = $this->woundsTable->toMeasurement($bonus, WoundsMeasurement::WOUNDS);
        $experiences = new ExperiencesMeasurement($wounds->getValue(), $unit, $this);

        switch ($unit) {
            case ExperiencesMeasurement::EXPERIENCES :
                return $experiences;
            case LevelMeasurement::LEVEL :
                return new LevelMeasurement($experiences->toLevel(), LevelMeasurement::LEVEL, $this);
            default :
                throw new \LogicException("Unknown unit $unit");
        }
    }

    /**
     * @param int $bonus
     *
     * @return int
     */
    public function toExperiences($bonus)
    {
        return ToInteger::toInteger($this->toMeasurement($bonus, ExperiencesMeasurement::EXPERIENCES)->getValue());
    }

    /**
     * @param int $bonus
     *
     * @return int
     */
    public function toLevel($bonus)
    {
        return $this->toMeasurement($bonus, LevelMeasurement::LEVEL)->toLevel();
    }

    /**
     * @param int $experiencesValue
     *
     * @return int
     */
    public function experiencesToLevel($experiencesValue)
    {
        return $this->toLevel($this->experiencesToBonus($experiencesValue));
    }

    /**
     * @param int $amount
     *
     * @return int
     */
    public function experiencesToBonus($amount)
    {
        return $this->woundsTable->woundsToBonus($amount);
    }

    /**
     * @param int $levelValue
     * @return int
     */
    public function levelToExperiences($levelValue)
    {
        return $this->toExperiences($this->levelToBonus($levelValue));
    }

    /**
     * @param int $levelValue
     * @return int
     */
    public function levelToTotalExperiences($levelValue)
    {
        return $this->toMeasurement($this->levelToBonus($levelValue), LevelMeasurement::LEVEL)->toTotalExperiences();
    }

    /**
     * @param int $levelValue
     *
     * @return int
     */
    public function levelToBonus($levelValue)
    {
        return $this->experiencesToBonus(LevelMeasurement::getIt($levelValue, $this)->toExperiences());
    }
}
