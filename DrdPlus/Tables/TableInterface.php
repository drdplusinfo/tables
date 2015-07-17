<?php
namespace DrdPlus\Tables;

interface TableInterface
{

    /**
     * @param MeasurementInterface $measurement
     *
     * @return int
     */
    public function toBonus(MeasurementInterface $measurement);

    /**
     * @param int $bonus
     * @param string $unit
     *
     * @return MeasurementInterface
     */
    public function toMeasurement($bonus, $unit);
}
