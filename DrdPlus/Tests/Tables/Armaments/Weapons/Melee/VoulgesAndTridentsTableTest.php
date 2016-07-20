<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\VoulgesAndTridentsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class VoulgesAndTridentsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::PITCHFORK, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 0],
            [WeaponCode::PITCHFORK, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::PITCHFORK, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::PITCHFORK, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCode::PITCHFORK, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::PITCHFORK, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::PITCHFORK, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCode::LIGHT_VOULGE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::LIGHT_VOULGE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::LIGHT_VOULGE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::LIGHT_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::LIGHT_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::LIGHT_VOULGE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::LIGHT_VOULGE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCode::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCode::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCode::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCode::HALBERD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCode::HALBERD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HALBERD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::HALBERD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCode::HALBERD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::HALBERD, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::HALBERD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.5],

            [WeaponCode::HEAVY_VOULGE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCode::HEAVY_VOULGE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HEAVY_VOULGE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::HEAVY_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 9],
            [WeaponCode::HEAVY_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::HEAVY_VOULGE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::HEAVY_VOULGE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCode::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCode::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCode::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCode::HEAVY_HALBERD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 10],
            [WeaponCode::HEAVY_HALBERD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HEAVY_HALBERD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::HEAVY_HALBERD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 12],
            [WeaponCode::HEAVY_HALBERD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::HEAVY_HALBERD, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::HEAVY_HALBERD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 6.0],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $voulgesAndTridentsTable = new VoulgesAndTridentsTable();
        foreach (WeaponCode::getVoulgeAndTridentCodes() as $voulgeAndTridentCode) {
            $row = $voulgesAndTridentsTable->getRow([$voulgeAndTridentCode]);
            self::assertNotEmpty($row);
        }
    }

}
