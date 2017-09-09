<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Partials;

interface WeaponStrengthSanctionsInterface extends StrengthSanctionsInterface
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