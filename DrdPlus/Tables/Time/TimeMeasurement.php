<?php
namespace DrdPlus\Tables\Time;

use DrdPlus\Tables\AbstractMeasurement;
use DrdPlus\Tables\Exceptions\DifferentValueExpectedForDifferentUnit;
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
        $this->checkValueInDifferentUnit($value, $unit);
        $this->inDifferentUnits[$unit] = ToFloat::toFloat($value);
    }

    protected function checkValueInDifferentUnit($newValue, $newUnit)
    {
        parent::checkValueInDifferentUnit($newValue, $newUnit);
        if ($newUnit === $this->getUnit()) {
            return;
        }
        if (ToFloat::toFloat($newValue) === ToFloat::toFloat($this->getValue())) {
            throw new DifferentValueExpectedForDifferentUnit(
                "New value $newValue ($newUnit) can not be same as current {$this->getValue()} ({$this->getUnit()})"
            );
        }

        $newUnitSequence = array_search($newUnit, $this->getPossibleUnits());
        $originalUnitSequence = array_search($this->getUnit(), $this->getPossibleUnits());
        // if key is lesser than the unit is smaller, see sequence in getPossibleUnits()
        if ($newUnitSequence < $originalUnitSequence) {
            if (ToFloat::toFloat($newValue) < ToFloat::toFloat($this->getValue())) {
                throw new Exceptions\PreviouslyDefinedUnitShouldBeGreater(
                    "Expected value lesser than {$this->getValue()} ({$this->getUnit()}), got $newValue ($newUnit)"
                );
            }
        } else if (ToFloat::toFloat($newValue) > ToFloat::toFloat($this->getValue())) {
            throw new Exceptions\LaterDefinedValueShouldBeLesser(
                "Expected value greater than {$this->getValue()} ({$this->getUnit()}), got $newValue ($newUnit)"
            );
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
