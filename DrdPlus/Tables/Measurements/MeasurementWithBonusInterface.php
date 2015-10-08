<?php
namespace DrdPlus\Tables\Measurements;

use DrdPlus\Tables\Measurements\Parts\AbstractBonus;

interface MeasurementWithBonusInterface extends MeasurementInterface
{
    /**
     * @return AbstractBonus
     */
    public function getBonus();

}
