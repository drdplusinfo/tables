<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Properties\Body\WeightInKg;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;

/**
 * See PPH page 88 right column, @link https://pph.drdplus.info/#tabulka_strelnych_a_vrhacich_zbrani
 */
class ThrowingWeaponsTable extends RangedWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/throwing_weapons.csv';
    }

    /**
     * @param RangedWeaponCode $throwingWeaponCode you need a code even for a custom weapon, so prove now
     * @param int $requiredStrength
     * @param int $lengthInMeters
     * @param int $offensiveness
     * @param int $wounds
     * @param WoundTypeCode $woundTypeCode
     * @param int $cover
     * @param WeightInKg $weightInKg
     * @param bool $twoHandedOnly
     * @throws \DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\Exceptions\NewRangedWeaponIsNotOfRequiredType
     */
    public function addNewThrowingWeapon(
        RangedWeaponCode $throwingWeaponCode,
        int $requiredStrength,
        int $lengthInMeters,
        int $offensiveness,
        int $wounds,
        WoundTypeCode $woundTypeCode,
        int $cover,
        WeightInKg $weightInKg,
        bool $twoHandedOnly
    )
    {
        $this->addNewRangedWeapon(
            WeaponCategoryCode::THROWING_WEAPON,
            $throwingWeaponCode,
            $requiredStrength,
            $lengthInMeters,
            $offensiveness,
            $wounds,
            $woundTypeCode,
            $cover,
            $weightInKg,
            $twoHandedOnly
        );
    }
}