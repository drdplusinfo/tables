<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WeaponlikeTable extends WoundingArmamentsTable, HeavyBearablesTable
{
    const COVER = 'cover';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getCoverOf($weaponlikeCode);

    const TWO_HANDED = 'two_handed';

    /**
     * @param $itemCode
     * @return bool
     */
    public function getTwoHandedOf($itemCode);
}