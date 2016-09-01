<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface MeleeWeaponlikeTableInterface extends WeaponlikeTableInterface
{
    const COVER = 'cover';
    const LENGTH = 'length';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getLengthOf($weaponlikeCode);

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getCoverOf($weaponlikeCode);
}