<?php
namespace DrdPlus\Tables\Measurements\Weight;

use DrdPlus\Properties\Base\Strength;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;
use DrdPlus\Tools\Calculations\SumAndRound;
use Granam\Integer\Tools\ToInteger;

/**
 * PPH page 164, bottom
 */
class WeightTable extends AbstractMeasurementFileTable
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

    public function toBonus(Weight $weight)
    {
        return $this->measurementToBonus($weight);
    }

    /**
     * @param int $bonusValue
     * @return WeightBonus
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
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

    /**
     * @param int $simplifiedBonus
     * @return WeightBonus
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    public function getBonusFromSimplifiedBonus($simplifiedBonus)
    {
        try {
            return $this->createBonus(ToInteger::toInteger($simplifiedBonus) + 12);
        } catch (\Granam\Integer\Tools\Exceptions\WrongParameterType $exception) {
            throw new BonusRequiresInteger($exception->getMessage());
        }
    }

    /**
     * @param Strength $strength
     * @param Weight $cargoWeight
     * @return int negative number or zero
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    public function getMalusFromLoad(Strength $strength, Weight $cargoWeight)
    {
        $requiredStrength = $cargoWeight->getBonus()->getValue();
        $missingStrength = $requiredStrength - $strength->getValue();

        return min( // negative number or zero
            -SumAndRound::half($missingStrength), // see PPH page 113, right column
            0
        );
    }

}