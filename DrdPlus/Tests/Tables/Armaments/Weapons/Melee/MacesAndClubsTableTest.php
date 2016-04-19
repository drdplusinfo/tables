<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class MacesAndClubsTableTest extends AbstractMeleeWeaponsTableTest
{

    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::CUDGEL, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCodes::CUDGEL, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::CUDGEL, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::CUDGEL, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::CUDGEL, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::CUDGEL, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCodes::CUDGEL, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.4],

            [WeaponCodes::CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCodes::CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCodes::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 5],
            [WeaponCodes::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCodes::LIGHT_MACE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCodes::LIGHT_MACE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::LIGHT_MACE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LIGHT_MACE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::LIGHT_MACE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::LIGHT_MACE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::LIGHT_MACE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCodes::MACE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 8],
            [WeaponCodes::MACE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::MACE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::MACE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCodes::MACE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::MACE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::MACE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCodes::HEAVY_CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 8],
            [WeaponCodes::HEAVY_CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::HEAVY_CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::HEAVY_CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCodes::HEAVY_CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HEAVY_CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::HEAVY_CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.5],

            [WeaponCodes::WAR_HAMMER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 10],
            [WeaponCodes::WAR_HAMMER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::WAR_HAMMER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCodes::WAR_HAMMER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCodes::WAR_HAMMER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::WAR_HAMMER, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::WAR_HAMMER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.5],

            [WeaponCodes::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCodes::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCodes::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 5.0],

            [WeaponCodes::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 13],
            [WeaponCodes::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 11],
            [WeaponCodes::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 5.0],
        ];
    }

}