<?php
namespace DrdPlus\Tables;

use DrdPlus\Tables\Parts\AbstractBonus;

interface MeasurementWithBonusInterface extends MeasurementInterface
{
    /**
     * @return AbstractBonus
     */
    public function getBonus();

}
