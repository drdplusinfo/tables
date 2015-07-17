<?php
namespace DrdPlus\Tables\Time;

use DrdPlus\Tables\AbstractMeasurement;
use Granam\Float\Tools\ToFloat;

class TimeMeasurement extends AbstractMeasurement
{
    private $inDifferentUnits = [];

    const ROUND = 'round';
    const MINUTE = 'minute';
    const HOUR = 'hour';
    const DAY = 'day';
    const MONTH = 'month';
    const YEAR = 'year';

    /**
     * @param float $value
     * @param string $unit
     */
    public function __construct($value, $unit)
    {
        parent::__construct($value, $unit);
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits()
    {
        return [self::ROUND, self::MINUTE, self::HOUR, self::DAY, self::MONTH, self::YEAR];
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkUnit($unit);
        $this->checkProportion($value, $unit, $this->getValue(), $this->getUnit());
        $this->inDifferentUnits[$unit] = ToFloat::toFloat($value);
    }

    private function checkProportion($value, $unit, $originalValue, $originalUnit)
    {
        if ($unit === $originalUnit) {
            if ($value !== $originalValue) {
                throw new \LogicException;
            }
            // if key is lesser then the unit is smaller, see sequence in getPossibleUnits()
        } else if (array_search($unit, $this->getPossibleUnits()) < array_search($originalUnit, $this->getPossibleUnits())) {
            if ($value >= $originalValue) {
                throw new \LogicException;
            }
        } else {
            if ($value <= $originalValue) {
                throw new \LogicException;
            }
        }
    }

    public function toRounds()
    {
        return $this->convertTo(self::ROUND);
    }

    private function convertTo($wantedUnit)
    {
        if ($wantedUnit === $this->getUnit()) {
            return $this->getValue();
        }
        if (isset($this->inDifferentUnits[$wantedUnit])) {
            return $this->inDifferentUnits[$wantedUnit];
        }
        throw new \LogicException(
            "Can not convert {$this->getValue()}({$this->getUnit()}) into $wantedUnit"
        );
    }

    public function toMinutes()
    {
        return $this->convertTo(self::MINUTE);
    }

    public function toHours()
    {
        return $this->convertTo(self::HOUR);
    }

    public function toDays()
    {
        return $this->convertTo(self::DAY);
    }

    public function toMonths()
    {
        return $this->convertTo(self::MONTH);
    }

    public function toYears()
    {
        return $this->convertTo(self::YEAR);
    }
}
