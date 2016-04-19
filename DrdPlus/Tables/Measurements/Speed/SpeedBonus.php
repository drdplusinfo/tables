<?php
namespace DrdPlus\Tables\Measurements\Speed;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

class SpeedBonus extends AbstractBonus
{

    /**
     * @var SpeedTable
     */
    private $speedTable;

    /**
     * @param int $bonusValue
     * @param SpeedTable $speedTable
     */
    public function __construct($bonusValue, SpeedTable $speedTable)
    {
        parent::__construct($bonusValue);
        $this->speedTable = $speedTable;
    }

    /**
     * @param string|null $wantedUnit
     * @return Speed
     */
    public function getSpeed($wantedUnit = null)
    {
        return $this->speedTable->toSpeed($this, $wantedUnit);
    }

}
