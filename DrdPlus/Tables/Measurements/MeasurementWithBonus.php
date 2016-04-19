<?php
namespace DrdPlus\Tables\Measurements;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

interface MeasurementWithBonus extends Measurement
{
    /**
     * @return AbstractBonus
     */
    public function getBonus();

}
