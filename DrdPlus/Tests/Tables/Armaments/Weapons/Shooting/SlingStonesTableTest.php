<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
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
            [WeaponCode::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCode::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::SLING_STONE_LIGHT, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCode::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCode::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCode::SLING_STONE_HEAVIER, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.2],
        ];
    }

}
