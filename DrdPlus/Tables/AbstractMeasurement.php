<?php
namespace DrdPlus\Tables;

use Granam\Float\Tools\ToFloat;
use Granam\Scalar\Tools\ValueDescriber;
use Granam\Strict\Object\StrictObject;

abstract class AbstractMeasurement extends StrictObject implements MeasurementInterface
{

    /**
     * @var float
     */
    private $value;
    /**
     * @var string
     */
    private $unit;

    /**
     * @param float $value
     * @param string $unit
     */
    protected function __construct($value, $unit)
    {
        $this->checkUnit($unit);
        $this->value = ToFloat::toFloat($value);
        $this->unit = $unit;
    }

    protected function checkUnit($unit)
    {
        if (!in_array($unit, $this->getPossibleUnits())) {
            throw new Exceptions\UnknownUnit('Unknown unit ' . ValueDescriber::describe($unit));
        }
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkUnit($unit);
        if ($unit === $this->getUnit() && $this->getValue() !== ToFloat::toFloat($value)) {
            throw new Exceptions\SameValueExpectedForSameUnit(
                "Value for unit {$this->getUnit()} is already set to value of {$this->getValue()}, " .
                'got ' . ValueDescriber::describe($value)
            );
        }
        // extend this method in child, if supports different units
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

}
