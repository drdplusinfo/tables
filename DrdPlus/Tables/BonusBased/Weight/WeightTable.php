<?php
namespace DrdPlus\Tables\BonusBased\Weight;
use DrdPlus\Tables\AbstractTable;
use DrdPlus\Tables\DummyEvaluator;

/**
 * PPH page 164, bottom
 * @method WeightMeasurement toMeasurement($bonus, $unit)
 */
class WeightTable extends AbstractTable
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
        return [WeightMeasurement::KG];
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toKg($bonus)
    {
        return $this->toMeasurement($bonus, WeightMeasurement::KG)->getValue();
    }

    public function kgToBonus($kg)
    {
        return $this->toBonus(new WeightMeasurement($kg, WeightMeasurement::KG));
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return WeightMeasurement
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new WeightMeasurement($value, $unit);
    }

}
