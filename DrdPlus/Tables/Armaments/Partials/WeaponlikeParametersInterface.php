<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WeaponlikeParametersInterface extends WeaponParametersInterface
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