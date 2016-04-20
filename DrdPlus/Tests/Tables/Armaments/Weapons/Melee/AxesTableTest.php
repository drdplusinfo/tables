<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class AxesTableTest extends AbstractMeleeWeaponsTableTest
{

    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::LIGHT_AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::LIGHT_AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::LIGHT_AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LIGHT_AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCodes::LIGHT_AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::LIGHT_AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::LIGHT_AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCodes::AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 5],
            [WeaponCodes::AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCodes::WAR_AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCodes::WAR_AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::WAR_AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::WAR_AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCodes::WAR_AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::WAR_AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::WAR_AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCodes::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 12],
            [WeaponCodes::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCodes::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],
        ];
    }

}