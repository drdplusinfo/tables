<?php
namespace DrdPlus\Tables\Measurements\Amount;

use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;

/**
 * @method int getValue
 */
class Amount extends AbstractMeasurementWithBonus
{
    const AMOUNT = 'amount';

    /**
     * @var AmountTable
     */
    private $amountTable;

    /**
     * @param int|IntegerInterface $value
     * @param string $unit
     * @param AmountTable $amountTable
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct($value, $unit, AmountTable $amountTable)
    {
        $this->amountTable = $amountTable;
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct($value, $unit);
    }

    /**
     * @param mixed $value
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    protected function normalizeValue($value)
    {
        return ToInteger::toInteger($value);
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