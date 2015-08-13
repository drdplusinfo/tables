<?php
namespace DrdPlus\Tables\BonusBased\Wounds;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Tables\BonusBased\AbstractTable;
use DrdPlus\Tables\DiceChanceEvaluator;

/**
 * PPH page 165, top
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
     * @param string $unit
     *
     * @return WoundsMeasurement
     */
    public function toMeasurement($bonus, $unit = WoundsMeasurement::WOUNDS)
    {
        return parent::toMeasurement($bonus, $unit);
    }

    /**
     * @param int $bonus
     *
     * @return int
     */
    public function toWounds($bonus)
    {
        return $this->toMeasurement($bonus)->getValue();
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
