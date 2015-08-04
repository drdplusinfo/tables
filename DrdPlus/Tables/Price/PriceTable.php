<?php
namespace DrdPlus\Tables\Price;

use DrdPlus\Tables\Amount\AmountTable;
use DrdPlus\Tables\MeasurementInterface;
use DrdPlus\Tables\TableInterface;

class PriceTable implements TableInterface
{
    /**
     * @var \DrdPlus\Tables\Amount\AmountTable
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
     * @param int $bonus
     * @param string $unit
     *
     * @return PriceMeasurement
     */
    public function toMeasurement($bonus, $unit)
    {
        $amount = $this->amountTable->toAmount($bonus);

        return new PriceMeasurement($amount, $unit);
    }

}
