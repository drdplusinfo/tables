<?php
namespace DrdPlus\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Parts\AbstractFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;

/**
 * PPH page 164, bottom
 * @method WeightBonus toBonus(Weight $weight)
 */
class WeightTable extends AbstractFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/weight.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Weight::KG];
    }

    /**
     * @param WeightBonus $weightBonus
     *
     * @return Weight
     */
    public function toWeight(WeightBonus $weightBonus)
    {
        return $this->toMeasurement($weightBonus, Weight::KG);
    }

    /**
     * @param int $bonusValue
     *
     * @return WeightBonus
     */
    protected function createBonus($bonusValue)
    {
        return new WeightBonus($bonusValue, $this);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Weight
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Weight($value, Weight::KG, $this);
    }

}
