<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\StaffsAndSpearsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class StaffsAndSpearsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::LIGHT_SPEAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCode::LIGHT_SPEAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::LIGHT_SPEAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LIGHT_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCode::LIGHT_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LIGHT_SPEAR, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::LIGHT_SPEAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::SHORTENED_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -4],
            [WeaponCode::SHORTENED_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::SHORTENED_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::SHORTENED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -1],
            [WeaponCode::SHORTENED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::SHORTENED_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::SHORTENED_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.3],

            [WeaponCode::LIGHT_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCode::LIGHT_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::LIGHT_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::LIGHT_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 0],
            [WeaponCode::LIGHT_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::LIGHT_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::LIGHT_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.5],

            [WeaponCode::SPEAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCode::SPEAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::SPEAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::SPEAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::SPEAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::SPEAR, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::SPEAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCode::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCode::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCode::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::LONG_SPEAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCode::LONG_SPEAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 5],
            [WeaponCode::LONG_SPEAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LONG_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCode::LONG_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LONG_SPEAR, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::LONG_SPEAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCode::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCode::PIKE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCode::PIKE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 6],
            [WeaponCode::PIKE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::PIKE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 8],
            [WeaponCode::PIKE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::PIKE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::PIKE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],

            [WeaponCode::METAL_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCode::METAL_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::METAL_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::METAL_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCode::METAL_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::METAL_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::METAL_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $staffsAndSpearsTable = new StaffsAndSpearsTable();
        foreach (WeaponCode::getStaffAndSpearCodes() as $staffAndSpearCode) {
            $row = $staffsAndSpearsTable->getRow([$staffAndSpearCode]);
            self::assertNotEmpty($row);
        }
    }

}
