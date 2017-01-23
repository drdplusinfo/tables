<?php
namespace DrdPlus\Tables\Combat\Attacks;

use DrdPlus\Tables\Combat\Attacks\Partials\AbstractAttackNumberByDistanceTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use Granam\Float\Tools\ToFloat;

/**
 * Data are calculated as -((Distance bonus / 2) - 9), see PPH page 104
 */
class ContinuousAttackNumberByDistanceTable extends AbstractAttackNumberByDistanceTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/continuous_attack_number_by_distance.csv';
    }

    const DISTANCE_IN_METERS = 'distance_in_meters';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::DISTANCE_IN_METERS];
    }

    /**
     * @param Distance $distance
     * @return int
     * @throws \DrdPlus\Tables\Combat\Attacks\Exceptions\DistanceOutOfKnownValues
     */
    public function getAttackNumberModifierByDistance(Distance $distance)
    {
        $distanceInMeters = $distance->getMeters();
        $orderedByDistanceDesc = $this->getOrderedByDistanceAsc();
        foreach ($orderedByDistanceDesc as $distanceInMetersTo => $row) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            if ($distanceInMeters <= ToFloat::toPositiveFloat($distanceInMetersTo)) { // including
                return $row[self::RANGED_ATTACK_NUMBER_MODIFIER];
            }
        }

        throw new Exceptions\DistanceOutOfKnownValues(
            "Given distance {$distance} is so far so we do not have values for it"
        );
    }
}