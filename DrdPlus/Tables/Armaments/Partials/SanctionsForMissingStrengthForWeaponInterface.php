<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface SanctionsForMissingStrengthForWeaponInterface extends SanctionsForMissingStrengthInterface
{
    /**
     * @param int $missingStrength
     * @return int
     */
    public function getAttackNumberSanction($missingStrength);

    /**
     * @param int $missingStrength
     * @return int
     */
    public function getBaseOfWoundsSanction($missingStrength);

    /**
     * @param int $missingStrength
     * @return int
     */
    public function getFightNumberSanction($missingStrength);

    /**
     * @param $missingStrength
     * @return int
     */
    public function getDefenseNumberSanction($missingStrength);
}