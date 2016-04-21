<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTableTest;

class ThrowingWeaponsTableTest extends AbstractShootingArmamentsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [WeaponCodes::ROCK, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -2],
            [WeaponCodes::ROCK, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::ROCK, AbstractShootingArmamentsTable::WOUNDS_HEADER, -2],
            [WeaponCodes::ROCK, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::ROCK, AbstractShootingArmamentsTable::RANGE_HEADER, 20],
            [WeaponCodes::ROCK, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.3],

            [WeaponCodes::THROWING_DAGGER, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 0],
            [WeaponCodes::THROWING_DAGGER, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::THROWING_DAGGER, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::THROWING_DAGGER, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::THROWING_DAGGER, AbstractShootingArmamentsTable::RANGE_HEADER, 14],
            [WeaponCodes::THROWING_DAGGER, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::RANGE_HEADER, 12],
            [WeaponCodes::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.7],

            [WeaponCodes::WAR_THROWING_AXE, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::WAR_THROWING_AXE, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::WAR_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_HEADER, 5],
            [WeaponCodes::WAR_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::WAR_THROWING_AXE, AbstractShootingArmamentsTable::RANGE_HEADER, 10],
            [WeaponCodes::WAR_THROWING_AXE, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::THROWING_HAMMER, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCodes::THROWING_HAMMER, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::THROWING_HAMMER, AbstractShootingArmamentsTable::WOUNDS_HEADER, 7],
            [WeaponCodes::THROWING_HAMMER, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::THROWING_HAMMER, AbstractShootingArmamentsTable::RANGE_HEADER, 9],
            [WeaponCodes::THROWING_HAMMER, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.5],

            [WeaponCodes::SHURIKEN, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCodes::SHURIKEN, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::SHURIKEN, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::SHURIKEN, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::SHURIKEN, AbstractShootingArmamentsTable::RANGE_HEADER, 14],
            [WeaponCodes::SHURIKEN, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCodes::SPEAR, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::SPEAR, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::SPEAR, AbstractShootingArmamentsTable::WOUNDS_HEADER, 3],
            [WeaponCodes::SPEAR, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::SPEAR, AbstractShootingArmamentsTable::RANGE_HEADER, 20],
            [WeaponCodes::SPEAR, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.2],

            [WeaponCodes::JAVELIN, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::JAVELIN, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::JAVELIN, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::JAVELIN, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::JAVELIN, AbstractShootingArmamentsTable::RANGE_HEADER, 22],
            [WeaponCodes::JAVELIN, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::SLING, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCodes::SLING, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::SLING, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::SLING, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::SLING, AbstractShootingArmamentsTable::RANGE_HEADER, 27],
            [WeaponCodes::SLING, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],
        ];
    }

}
