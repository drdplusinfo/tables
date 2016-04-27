<?php
namespace DrdPlus\Tables\Measurements;

interface MeasurementWithBonus extends Measurement
{
    /**
     * @return Bonus
     */
    public function getBonus();

}
