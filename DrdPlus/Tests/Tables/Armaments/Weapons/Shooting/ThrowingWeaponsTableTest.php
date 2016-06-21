<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
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
            [WeaponCode::ROCK, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -2],
            [WeaponCode::ROCK, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::ROCK, AbstractShootingArmamentsTable::WOUNDS_HEADER, -2],
            [WeaponCode::ROCK, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::ROCK, AbstractShootingArmamentsTable::RANGE_HEADER, 20],
            [WeaponCode::ROCK, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.3],

            [WeaponCode::THROWING_DAGGER, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 0],
            [WeaponCode::THROWING_DAGGER, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::THROWING_DAGGER, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCode::THROWING_DAGGER, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::THROWING_DAGGER, AbstractShootingArmamentsTable::RANGE_HEADER, 14],
            [WeaponCode::THROWING_DAGGER, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.2],

            [WeaponCode::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCode::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::RANGE_HEADER, 12],
            [WeaponCode::LIGHT_THROWING_AXE, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.7],

            [WeaponCode::WAR_THROWING_AXE, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::WAR_THROWING_AXE, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::WAR_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_HEADER, 5],
            [WeaponCode::WAR_THROWING_AXE, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::WAR_THROWING_AXE, AbstractShootingArmamentsTable::RANGE_HEADER, 10],
            [WeaponCode::WAR_THROWING_AXE, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::THROWING_HAMMER, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCode::THROWING_HAMMER, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::THROWING_HAMMER, AbstractShootingArmamentsTable::WOUNDS_HEADER, 7],
            [WeaponCode::THROWING_HAMMER, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::THROWING_HAMMER, AbstractShootingArmamentsTable::RANGE_HEADER, 9],
            [WeaponCode::THROWING_HAMMER, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.5],

            [WeaponCode::SHURIKEN, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCode::SHURIKEN, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::SHURIKEN, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCode::SHURIKEN, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::SHURIKEN, AbstractShootingArmamentsTable::RANGE_HEADER, 14],
            [WeaponCode::SHURIKEN, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCode::SPEAR, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCode::SPEAR, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::SPEAR, AbstractShootingArmamentsTable::WOUNDS_HEADER, 3],
            [WeaponCode::SPEAR, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::SPEAR, AbstractShootingArmamentsTable::RANGE_HEADER, 20],
            [WeaponCode::SPEAR, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.2],

            [WeaponCode::JAVELIN, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::JAVELIN, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::JAVELIN, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCode::JAVELIN, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::JAVELIN, AbstractShootingArmamentsTable::RANGE_HEADER, 22],
            [WeaponCode::JAVELIN, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::SLING, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCode::SLING, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::SLING, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCode::SLING, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::SLING, AbstractShootingArmamentsTable::RANGE_HEADER, 27],
            [WeaponCode::SLING, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],
        ];
    }

}
