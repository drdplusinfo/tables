<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Tables\Environments\Partials\AbstractAttackNumberByDistanceTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use Granam\Float\Tools\ToFloat;

class AttackNumberByDistanceTable extends AbstractAttackNumberByDistanceTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/attack_number_by_distance_table.csv';
    }

    const DISTANCE_IN_METERS_UP_TO = 'distance_in_meters_up_to';

    protected function getRowsHeader()
    {
        return [self::DISTANCE_IN_METERS_UP_TO];
    }

    /**
     * @param Distance $distance
     * @return int
     */
    public function getAttackNumberModifierByDistance(Distance $distance)
    {
        $distanceInMeters = $distance->getMeters();
        $orderedByDistanceDesc = $this->getOrderedByDistanceAsc();
        foreach ($orderedByDistanceDesc as $distanceInMetersUpTo => $row) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            if ($distanceInMeters < ToFloat::toPositiveFloat($distanceInMetersUpTo)) { // excluding
                return $row[self::RANGED_ATTACK_NUMBER_MODIFICATION];
            }
        }

        // the highest range fits to any higher distance
        return end($orderedByDistanceDesc)[self::RANGED_ATTACK_NUMBER_MODIFICATION];
    }
}