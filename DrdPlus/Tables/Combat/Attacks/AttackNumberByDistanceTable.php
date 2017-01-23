<?php
namespace DrdPlus\Tables\Combat\Attacks;

use DrdPlus\Tables\Combat\Attacks\Partials\AbstractAttackNumberByDistanceTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use Granam\Float\Tools\ToFloat;

/**
 * See PPH page 104 left column bottom, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_oprav_za_vzdalenost
 */
class AttackNumberByDistanceTable extends AbstractAttackNumberByDistanceTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/attack_number_by_distance.csv';
    }

    const DISTANCE_IN_METERS_FROM = 'distance_in_meters_from';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::DISTANCE_IN_METERS_FROM];
    }

    /**
     * @param Distance $distance
     * @return int
     */
    public function getAttackNumberModifierByDistance(Distance $distance)
    {
        $distanceInMeters = $distance->getMeters();
        $orderedByDistanceDesc = $this->getOrderedByDistanceAsc();
        $attackNumberModifierCandidate = null;
        foreach ($orderedByDistanceDesc as $distanceInMetersFrom => $row) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            if ($distanceInMeters >= ToFloat::toPositiveFloat($distanceInMetersFrom)) {
                $attackNumberModifierCandidate = $row[self::RANGED_ATTACK_NUMBER_MODIFIER];
            }
        }

        return $attackNumberModifierCandidate;
    }
}