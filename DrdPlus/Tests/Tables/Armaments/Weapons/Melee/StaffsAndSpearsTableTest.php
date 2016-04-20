<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class StaffsAndSpearsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::LIGHT_SPEAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCodes::LIGHT_SPEAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::LIGHT_SPEAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LIGHT_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::LIGHT_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LIGHT_SPEAR, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::LIGHT_SPEAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::SHORTENED_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -4],
            [WeaponCodes::SHORTENED_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::SHORTENED_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::SHORTENED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -1],
            [WeaponCodes::SHORTENED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::SHORTENED_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::SHORTENED_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.3],

            [WeaponCodes::LIGHT_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCodes::LIGHT_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::LIGHT_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::LIGHT_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::LIGHT_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::LIGHT_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::LIGHT_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.5],

            [WeaponCodes::SPEAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::SPEAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::SPEAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::SPEAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::SPEAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::SPEAR, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::SPEAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCodes::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCodes::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::LONG_SPEAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCodes::LONG_SPEAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 5],
            [WeaponCodes::LONG_SPEAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LONG_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCodes::LONG_SPEAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_SPEAR, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::LONG_SPEAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCodes::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::HEAVY_HOBNAILED_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCodes::PIKE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCodes::PIKE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 6],
            [WeaponCodes::PIKE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::PIKE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 8],
            [WeaponCodes::PIKE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::PIKE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::PIKE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],

            [WeaponCodes::METAL_STAFF, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCodes::METAL_STAFF, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::METAL_STAFF, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::METAL_STAFF, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCodes::METAL_STAFF, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::METAL_STAFF, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::METAL_STAFF, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],
        ];
    }

}
