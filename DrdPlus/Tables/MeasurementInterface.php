<?php
namespace DrdPlus\Tables;

interface MeasurementInterface
{

    /**
     * @return float
     */
    public function getValue();

    /**
     * @return string
     */
    public function getUnit();

    /**
     * @return string[]
     */
    public function getPossibleUnits();

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit);
}
