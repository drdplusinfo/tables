<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTableTest;

class SlingStonesTableTest extends AbstractShootingArmamentsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [WeaponCodes::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCodes::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCodes::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.2],
        ];
    }

}
