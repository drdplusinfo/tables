<?php
namespace DrdPlus\Tables\Measurements\Amount;

use DrdPlus\Tables\Measurements\Parts\AbstractMeasurementWithBonus;

class Amount extends AbstractMeasurementWithBonus
{
    const AMOUNT = 'amount';

    /**
     * @var AmountTable
     */
    private $amountTable;

    /**
     * @param float $value
     * @param string $unit
     * @param AmountTable $amountTable
     */
    public function __construct($value, $unit, AmountTable $amountTable)
    {
        $this->amountTable = $amountTable;
        parent::__construct($value, $unit);
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits()
    {
        return [self::AMOUNT];
    }

    /**
     * @return AmountBonus
     */
    public function getBonus()
    {
        return $this->amountTable->toBonus($this);
    }

}
