<?php
namespace DrdPlus\Tables\Measurements\Amount;

use Drd\DiceRoll\Templates\Rollers\Roller1d6;
use DrdPlus\Tables\Measurements\Parts\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DiceChanceEvaluator;

/**
 * PPH page 164, top
 */
class AmountTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DiceChanceEvaluator(Roller1d6::getIt()));
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/amount.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Amount::AMOUNT];
    }

    /**
     * @param AmountBonus $bonus
     *
     * @return Amount
     */
    public function toAmount(AmountBonus $bonus)
    {
        return $this->toMeasurement($bonus);
    }

    /**
     * @param Amount $amount
     * @return AmountBonus
     */
    public function toBonus(Amount $amount)
    {
        return $this->measurementToBonus($amount);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Amount
     */
    protected function convertToMeasurement($value, $unit)
    {
        $this->checkUnit($unit);

        return new Amount($value, Amount::AMOUNT, $this);
    }

    /**
     * @param $bonusValue
     *
     * @return AmountBonus
     */
    protected function createBonus($bonusValue)
    {
        return new AmountBonus($bonusValue, $this);
    }

}
