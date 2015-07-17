<?php
namespace DrdPlus\Tables\Wounds;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Tables\AbstractTable;
use DrdPlus\Tables\DiceChanceEvaluator;

/**
 * PPH page 165, top
 * @method WoundsMeasurement toMeasurement($bonus, $unit)
 */
class WoundsTable extends AbstractTable
{
    public function __construct()
    {
        parent::__construct(new DiceChanceEvaluator(new Roll1d6()));
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/wounds.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [WoundsMeasurement::WOUNDS];
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toWounds($bonus)
    {
        return $this->toMeasurement($bonus, WoundsMeasurement::WOUNDS)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function woundsToBonus($amount)
    {
        return $this->toBonus(new WoundsMeasurement($amount, WoundsMeasurement::WOUNDS));
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return WoundsMeasurement
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new WoundsMeasurement($value, $unit);
    }

}
