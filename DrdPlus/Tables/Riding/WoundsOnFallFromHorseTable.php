<?php
namespace DrdPlus\Tables\Riding;

use DrdPlus\Codes\Transport\RidingAnimalMovementCode;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Partials\AbstractFileTable;

/**
 * See PPH page 122 right column bottom, @link https://pph.drdplus.info/#tabulka_zraneni_pri_padu_z_kone
 */
class WoundsOnFallFromHorseTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/wounds_on_fall_from_horse.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return ['activity'];
    }

    const WOUNDS_MODIFICATION = 'wounds_modification';
    const ADDITIONAL = 'additional';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [self::WOUNDS_MODIFICATION => self::INTEGER, self::ADDITIONAL => self::BOOLEAN];
    }

    const STILL = RidingAnimalMovementCode::STILL;
    const GAIT = RidingAnimalMovementCode::GAIT;
    const TROT = RidingAnimalMovementCode::TROT;
    const CANTER = RidingAnimalMovementCode::CANTER;
    const GALLOP = RidingAnimalMovementCode::GALLOP;
    const JUMPING = RidingAnimalMovementCode::JUMPING;

    /**
     * @param RidingAnimalMovementCode $ridingAnimalMovementCode
     * @param bool $jumping
     * @param WoundsTable $woundsTable
     * @return WoundsBonus
     */
    public function getWoundsAdditionOnFallFromHorse(
        RidingAnimalMovementCode $ridingAnimalMovementCode,
        bool $jumping,
        WoundsTable $woundsTable
    ): WoundsBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new WoundsBonus(
            $this->getValue([$ridingAnimalMovementCode->getValue()], self::WOUNDS_MODIFICATION)
            + ($jumping
                ? $this->getValue([RidingAnimalMovementCode::JUMPING], self::WOUNDS_MODIFICATION)
                : 0
            ),
            $woundsTable
        );
    }

}