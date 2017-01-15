<?php
namespace DrdPlus\Tables\Measurements\Amount;

use Drd\DiceRoll\Templates\Rollers\Roller1d6;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DiceChanceEvaluator;

/**
 * See PPH page 164 top, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_poctu
 */
class AmountTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DiceChanceEvaluator(Roller1d6::getIt()));
    }

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/amount.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeader()
    {
        return [Amount::AMOUNT];
    }

    /**
     * @param AmountBonus $bonus
     * @return Amount|MeasurementWithBonus
     */
    public function toAmount(AmountBonus $bonus)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($bonus);
    }

    /**
     * @param Amount $amount
     * @return AmountBonus|AbstractBonus
     */
    public function toBonus(Amount $amount)
    {
        return $this->measurementToBonus($amount);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return Amount
     */
    protected function convertToMeasurement($value, $unit)
    {
        $this->checkUnitExistence($unit);

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new Amount($value, Amount::AMOUNT, $this);
    }

    /**
     * @param $bonusValue
     * @return AmountBonus
     */
    protected function createBonus($bonusValue)
    {
        return new AmountBonus($bonusValue, $this);
    }

}