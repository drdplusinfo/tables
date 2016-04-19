<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface MeleeWeaponParametersInterface extends CoveringWeaponParametersInterface
{
    const LENGTH_HEADER = 'length';

    /**
     * @param string $weaponCode
     * @return int
     */
    public function getLengthOf($weaponCode);
}