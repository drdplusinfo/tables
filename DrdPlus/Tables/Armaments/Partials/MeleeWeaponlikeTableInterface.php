<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface MeleeWeaponlikeTableInterface extends WeaponlikeTableInterface
{
    const LENGTH = 'length';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getLengthOf($weaponlikeCode);

}