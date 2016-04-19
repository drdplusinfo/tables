<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface CoveringWeaponParametersInterface extends WeaponParametersInterface
{
    const COVER_HEADER = 'cover';

    /**
     * @param string $weaponCode
     * @return int
     */
    public function getCoverOf($weaponCode);
}