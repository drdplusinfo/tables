<?php
namespace DrdPlus\Tables;

use Granam\Float\Tools\ToFloat;
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
            throw new \LogicException('Unknown unit ' . var_export($unit, true));
        }
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
