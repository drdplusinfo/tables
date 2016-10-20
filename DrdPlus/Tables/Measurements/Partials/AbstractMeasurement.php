<?php
namespace DrdPlus\Tables\Measurements\Partials;

use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Measurement;
use Granam\Float\Tools\ToFloat;
use Granam\Tools\ValueDescriber;
use Granam\Strict\Object\StrictObject;

abstract class AbstractMeasurement extends StrictObject implements Measurement
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
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    protected function __construct($value, $unit)
    {
        $this->value = $this->normalizeValue($value);
        $this->checkUnit($unit);
        $this->unit = $unit;
    }

    /**
     * @param mixed $value
     * @return number
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    protected function normalizeValue($value)
    {
        return ToFloat::toFloat($value);
    }

    /**
     * @param string $unit
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     */
    protected function checkUnit($unit)
    {
        if (!in_array($unit, $this->getPossibleUnits(), true)) {
            throw new UnknownUnit('Unknown unit ' . ValueDescriber::describe($unit));
        }
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
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
    public function __toString()
    {
        return (string)$this->getValue() . ' ' . $this->getUnit();
    }

}