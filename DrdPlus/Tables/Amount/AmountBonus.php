<?php
namespace DrdPlus\Tables\Amount;

use DrdPlus\Tables\Parts\AbstractBonus;

class AmountBonus extends AbstractBonus
{
    /**
     * @var AmountTable
     */
    private $amountTable;

    /**
     * @param int $bonusValue
     * @param AmountTable $amountTable
     */
    public function __construct($bonusValue, AmountTable $amountTable)
    {
        parent::__construct($bonusValue);
        $this->amountTable = $amountTable;
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amountTable->toAmount($this);
    }

}
