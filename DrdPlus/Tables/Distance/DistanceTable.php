<?php
namespace DrdPlus\Tables\Distance;

use DrdPlus\Tables\Parts\AbstractFileTable;
use DrdPlus\Tables\Tools\DummyEvaluator;

/**
 * PPH page 162, top
 *
 * @method DistanceBOnus toBonus(Distance $distance)
 */
class DistanceTable extends AbstractFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/distance.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Distance::M, Distance::KM, Distance::LIGHT_YEAR];
    }

    /**
     * @param DistanceBonus $distanceBonus
     *
     * @return Distance
     */
    public function toDistance(DistanceBonus $distanceBonus)
    {
        return $this->toMeasurement($distanceBonus);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Distance
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Distance($value, $unit, $this);
    }

    /**
     * @param int $bonusValue
     *
     * @return DistanceBonus
     */
    protected function createBonus($bonusValue)
    {
        return new DistanceBonus($bonusValue, $this);
    }

}
