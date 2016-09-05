<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface MeleeWeaponlikeTable extends WeaponlikeTable
{
    const LENGTH = 'length';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getLengthOf($weaponlikeCode);

}