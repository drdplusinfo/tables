<?php
namespace DrdPlus\Tables\Speed;

use DrdPlus\Tables\AbstractMeasurement;
use Granam\Float\Tools\ToFloat;

class SpeedMeasurement extends AbstractMeasurement
{
    private $inDifferentUnits = [];

    const M_PER_ROUND = 'm/round';
    const KM_PER_HOUR = 'km/h';

    /**
     * @param float $value
     * @param string $unit
     */
    public function __construct($value, $unit)
    {
        parent::__construct($value, $unit);
    }

    public function getPossibleUnits()
    {
        return [self::M_PER_ROUND, self::KM_PER_HOUR];
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        parent::checkValueInDifferentUnit($value, $unit);
        $this->checkProportion($value, $unit, $this->getValue(), $this->getUnit());
        if ($this->getUnit() !== $unit) {
            $this->inDifferentUnits[$unit] = ToFloat::toFloat($value);
        }
    }

    private function checkProportion($value, $unit, $originalValue, $originalUnit)
    {
        if ($unit === self::M_PER_ROUND && $originalUnit === self::KM_PER_HOUR) {
            if ($value <= $originalValue) {
                throw new \LogicException;
            }
        } else if ($unit === self::KM_PER_HOUR && $originalUnit === self::M_PER_ROUND) {
            if ($value >= $originalValue) {
                throw new \LogicException;
            }
        }
    }

    public function toMetersPerRound()
    {
        return $this->convertTo(self::M_PER_ROUND);
    }

    private function convertTo($wantedUnit)
    {
        if ($this->getUnit() === $wantedUnit) {
            return $this->getValue();
        }
        if (isset($this->inDifferentUnits[$wantedUnit])) {
            // conversion has been set already
            return $this->inDifferentUnits[$wantedUnit];
        }
        throw new \LogicException(
            "Can not convert {$this->getValue()}({$this->getUnit()}) into $wantedUnit"
        );
    }

    public function toKilometersPerHour()
    {
        return $this->convertTo(self::KM_PER_HOUR);
    }
}
