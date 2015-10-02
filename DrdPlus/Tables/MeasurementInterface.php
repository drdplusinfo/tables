<?php
namespace DrdPlus\Tables;

use Granam\Number\NumberInterface;

interface MeasurementInterface extends NumberInterface
{

    /**
     * @return string
     */
    public function getUnit();

    /**
     * @return array|string[]
     */
    public function getPossibleUnits();

}
