<?php
namespace DrdPlus\Tables\Measurements;

use Granam\Number\NumberInterface;

interface Measurement extends NumberInterface
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
