<?php
namespace DrdPlus\Tables\Armaments\Partials;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;

interface MeleeWeaponlikesTable extends WeaponlikeTable
{
    const LENGTH = 'length';

    /**
     * @param string|MeleeWeaponCode $weaponlikeCode
     * @return int
     */
    public function getLengthOf($weaponlikeCode): int;

}