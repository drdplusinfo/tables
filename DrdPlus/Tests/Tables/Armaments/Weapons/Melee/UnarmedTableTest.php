<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class UnarmedTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::HAND, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::HAND, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCodes::HAND, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::HAND, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -2],
            [WeaponCodes::HAND, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HAND, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCodes::HAND, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],

            [WeaponCodes::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCodes::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCodes::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],

            [WeaponCodes::LEG, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::LEG, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCodes::LEG, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, -1],
            [WeaponCodes::LEG, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::LEG, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::LEG, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCodes::LEG, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],

            [WeaponCodes::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCodes::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, -2],
            [WeaponCodes::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCodes::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],
        ];
    }

}
