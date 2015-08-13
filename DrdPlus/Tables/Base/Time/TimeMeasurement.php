<?php
namespace DrdPlus\Tables\Base\Time;

use DrdPlus\Tables\AbstractMeasurement;
use DrdPlus\Tables\Exceptions\DifferentValueExpectedForDifferentUnit;
use Granam\Float\Tools\ToFloat;
use Granam\Integer\Tools\ToInteger;

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
     * @return float|int
     */
    public function getValue()
    {
        if ($this->getUnit() === self::ROUND || $this->getUnit() === self::MINUTE) {
            return ToInteger::toInteger(parent::getValue());
        }

        return parent::getValue();
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

}
