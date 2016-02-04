<?php
namespace DrdPlus\Tables\Measurements\Parts;

use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\MeasurementInterface;
use Granam\Float\Tools\ToFloat;
use Granam\Tools\ValueDescriber;
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
        $this->value = $this->normalizeValue($value);
        $this->checkUnit($unit);
        $this->unit = $unit;
    }

    /**
     * @param mixed $value
     *
     * @return number
     */
    protected function normalizeValue($value)
    {
        return ToFloat::toFloat($value);
    }

    protected function checkUnit($unit)
    {
        if (!in_array($unit, $this->getPossibleUnits())) {
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
        return (string)$this->getValue();
    }

}
