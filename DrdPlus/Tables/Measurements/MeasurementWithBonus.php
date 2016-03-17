<?php
namespace DrdPlus\Tables\Measurements;

use DrdPlus\Tables\Measurements\Parts\AbstractBonus;

interface MeasurementWithBonus extends Measurement
{
    /**
     * @return AbstractBonus
     */
    public function getBonus();

}
