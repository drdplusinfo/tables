<?php
namespace DrdPlus\Tables\Armaments\Partials;

use Granam\String\StringInterface;

interface MeleeWeaponlikesTable extends WeaponlikeTable
{
    const LENGTH = 'length';

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     */
    public function getLengthOf($weaponlikeCode): int;

}