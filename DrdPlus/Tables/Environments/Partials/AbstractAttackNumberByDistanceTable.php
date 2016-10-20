<?php
namespace DrdPlus\Tables\Environments\Partials;

use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Float\Tools\ToFloat;

abstract class AbstractAttackNumberByDistanceTable extends AbstractFileTable
{

    const DISTANCE_BONUS = 'distance_bonus';
    const RANGED_ATTACK_NUMBER_MODIFICATION = 'ranged_attack_number_modification';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::DISTANCE_BONUS => self::POSITIVE_INTEGER,
            self::RANGED_ATTACK_NUMBER_MODIFICATION => self::INTEGER,
        ];
    }

    /**
     * @param Distance $distance
     * @return int
     */
    abstract public function getAttackNumberModifierByDistance(Distance $distance);

    /**
     * Values may be already ordered from file, but have to be sure.
     *
     * @return array|\string[][]
     */
    protected function getOrderedByDistanceAsc()
    {
        $values = $this->getIndexedValues();
        uksort($values, function ($oneDistanceInMeters, $anotherDistanceInMeters) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $oneDistanceInMeters = ToFloat::toPositiveFloat($oneDistanceInMeters);
            $anotherDistanceInMeters = ToFloat::toPositiveFloat($anotherDistanceInMeters);
            if ($oneDistanceInMeters < $anotherDistanceInMeters) {
                return -1; // lowest first
            }
            if ($oneDistanceInMeters > $anotherDistanceInMeters) {
                return 1;
            }

            return 0;
        });

        return $values;
    }
}