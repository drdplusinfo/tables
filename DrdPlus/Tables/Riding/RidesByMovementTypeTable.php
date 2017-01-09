<?php
namespace DrdPlus\Tables\Riding;

use DrdPlus\Codes\Transport\RidingAnimalMovementCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

/**
 * See PPH page 122 right column (table without name), @link https://pph.drdplus.jaroslavtyc.com/#tabulka_jizdy_podle_druhu_pohybu
 */
class RidesByMovementTypeTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/rides.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return ['movement_type'];
    }

    const RIDE = 'ride';
    const ADDITIONAL = 'additional';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::RIDE => self::INTEGER, self::ADDITIONAL => self::BOOLEAN];
    }

    /**
     * @param RidingAnimalMovementCode $ridingAnimalMovementCode
     * @param bool $jumping
     * @return Ride
     */
    public function getRideFor(RidingAnimalMovementCode $ridingAnimalMovementCode, $jumping)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new Ride(
            $this->getValue([$ridingAnimalMovementCode->getValue()], self::RIDE)
            + ($jumping
                ? $this->getValue([RidingAnimalMovementCode::JUMPING], self::RIDE)
                : 0)
        );
    }

}