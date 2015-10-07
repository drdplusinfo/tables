<?php
namespace DrdPlus\Tables\Speed;

use DrdPlus\Tables\Parts\AbstractFileTable;
use DrdPlus\Tables\Tools\DummyEvaluator;

/**
 * PPH page 163
 *
 * @method SpeedBonus toBonus(Speed $speed)
 */
class SpeedTable extends AbstractFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/speed.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Speed::M_PER_ROUND, Speed::KM_PER_HOUR];
    }

    /**
     * @param float $bonusValue
     *
     * @return SpeedBonus
     */
    protected function createBonus($bonusValue)
    {
        return new SpeedBonus($bonusValue, $this);
    }

    /**
     * @param SpeedBonus $bonus
     * @param string|null $wantedUnit
     *
     * @return Speed
     */
    public function toSpeed(SpeedBonus $bonus, $wantedUnit = null)
    {
        return $this->toMeasurement($bonus, $wantedUnit);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Speed
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Speed($value, $unit, $this);
    }

}
