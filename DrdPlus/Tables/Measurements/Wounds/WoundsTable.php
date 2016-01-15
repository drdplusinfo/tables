<?php
namespace DrdPlus\Tables\Measurements\Wounds;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Tables\Measurements\Parts\AbstractFileTable;
use DrdPlus\Tables\Measurements\Tools\DiceChanceEvaluator;

/**
 * PPH page 165, top
 */
class WoundsTable extends AbstractFileTable
{
    public function __construct()
    {
        parent::__construct(new DiceChanceEvaluator(new Roll1d6()));
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/wounds.csv';
    }

    protected function getExpectedColumnsHeader()
    {
        return [Wounds::WOUNDS];
    }

    /**
     * @param WoundsBonus $bonus
     *
     * @return Wounds
     */
    public function toWounds(WoundsBonus $bonus)
    {
        return $this->toMeasurement($bonus);
    }

    /**
     * @param Wounds $wounds
     * @return WoundsBonus
     */
    public function toBonus(Wounds $wounds)
    {
        return $this->measurementToBonus($wounds);
    }

    /**
     * @param int $bonusValue
     *
     * @return WoundsBonus
     */
    protected function createBonus($bonusValue)
    {
        return new WoundsBonus($bonusValue, $this);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Wounds
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Wounds($value, $unit, $this);
    }

}
