<?php
namespace DrdPlus\Tables\Derived\Price;

use DrdPlus\Tables\BonusBased\Amount\AmountTable;
use DrdPlus\Tables\MeasurementInterface;

class PriceTable
{
    /**
     * @var \DrdPlus\Tables\BonusBased\Amount\AmountTable
     */
    private $amountTable;

    public function __construct(AmountTable $amountTable)
    {
        $this->amountTable = $amountTable;
    }

    /**
     * @param \DrdPlus\Tables\MeasurementInterface $measurement
     *
     * @return int
     */
    public function toBonus(MeasurementInterface $measurement)
    {
        return $this->amountTable->amountToBonus($measurement->getValue());
    }

    /**
     * @param int $amountBonus
     * @param string $unit
     *
     * @return PriceMeasurement
     */
    public function toMeasurement($amountBonus, $unit)
    {
        $amount = $this->amountTable->toAmount($amountBonus);

        return new PriceMeasurement($amount, $unit);
    }

}
