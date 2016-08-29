<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Partials\AbstractMeleeWeaponlikeSanctionsByMissingStrengthTable;

class MeleeWeaponSanctionsByMissingStrengthTable extends AbstractMeleeWeaponlikeSanctionsByMissingStrengthTable
{
    const CAN_USE_WEAPON = self::CAN_USE_ARMAMENT;

    /**
     * @param $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseWeapon($missingStrength)
    {
        return $this->canUseArmament($missingStrength);
    }
}