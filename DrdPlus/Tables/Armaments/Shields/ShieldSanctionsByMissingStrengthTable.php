<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Partials\AbstractMeleeArmamentSanctionsByMissingStrengthTable;

/**
 * Shield uses same sanctions as a weapon
 */
class ShieldSanctionsByMissingStrengthTable extends AbstractMeleeArmamentSanctionsByMissingStrengthTable
{
    /**
     * @param $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseShield($missingStrength)
    {
        return $this->canUseArmament($missingStrength);
    }
}