<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface CoveringWeaponParametersInterface extends WeaponParametersInterface
{
    const COVER = 'cover';

    /**
     * @param string $weaponCode
     * @return int
     */
    public function getCoverOf($weaponCode);
}