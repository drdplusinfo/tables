<?php
namespace DrdPlus\Tables\Measurements\Wounds;

use Drd\DiceRolls\Templates\Rollers\Roller1d6;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DiceChanceEvaluator;

/**
 * Note: fatigue table is equal to wounds table.
 * See PPH page 165 top, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_zraneni_a_unavy
 * Bonus can be calculated as 20*log(value)-10 and value as 10**(bonus/20 + 0.5),
 * but few values where rounded in the resulting table.
 */
class WoundsTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DiceChanceEvaluator(Roller1d6::getIt()));
    }

    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/wounds.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Wounds::WOUNDS];
    }

    /**
     * @param WoundsBonus $bonus
     * @return Wounds|MeasurementWithBonus
     */
    public function toWounds(WoundsBonus $bonus)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($bonus);
    }

    /**
     * @param Wounds $wounds
     * @return WoundsBonus|AbstractBonus
     */
    public function toBonus(Wounds $wounds)
    {
        return $this->measurementToBonus($wounds);
    }

    /**
     * @param int $bonusValue
     * @return WoundsBonus
     */
    protected function createBonus($bonusValue)
    {
        return new WoundsBonus($bonusValue, $this);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return Wounds
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Wounds($value, $this, $unit);
    }

}