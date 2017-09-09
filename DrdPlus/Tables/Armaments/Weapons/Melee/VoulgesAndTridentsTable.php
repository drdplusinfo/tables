<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Properties\Body\WeightInKg;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

/**
 * See PPH page 85, @link https://pph.drdplus.info/#tabulka_zbrani_jednorucni_zbrane
 */
class VoulgesAndTridentsTable extends MeleeWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/voulges_and_tridents.csv';
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode you need a code even for a custom weapon, so prove now
     * @param int $requiredStrength
     * @param int $lengthInMeters
     * @param int $offensiveness
     * @param int $wounds
     * @param WoundTypeCode $woundTypeCode
     * @param int $cover
     * @param WeightInKg $weightInKg
     * @param bool $twoHandedOnly
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\NewMeleeWeaponIsNotOfRequiredType
     */
    public function addNewVoulgeOrTrident(
        MeleeWeaponCode $meleeWeaponCode,
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
        $this->addNewMeleeWeapon(
            WeaponCategoryCode::VOULGE_AND_TRIDENT,
            $meleeWeaponCode,
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