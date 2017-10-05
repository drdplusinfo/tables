<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Amount;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use Granam\Integer\IntegerInterface;

class AmountBonus extends AbstractBonus
{
    /**
     * @var AmountTable
     */
    private $amountTable;

    /**
     * @param int|IntegerInterface $bonusValue
     * @param AmountTable $amountTable
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    public function __construct($bonusValue, AmountTable $amountTable)
    {
        parent::__construct($bonusValue);
        $this->amountTable = $amountTable;
    }

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amountTable->toAmount($this);
    }

}
