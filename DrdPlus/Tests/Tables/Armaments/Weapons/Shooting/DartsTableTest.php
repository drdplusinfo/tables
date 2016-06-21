<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTableTest;

class DartsTableTest extends AbstractShootingArmamentsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [WeaponCode::BASIC_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::BASIC_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::BASIC_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCode::BASIC_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::BASIC_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::BASIC_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::WAR_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::WAR_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::WAR_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCode::WAR_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::WAR_DART, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCode::WAR_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCode::PIERCING_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::PIERCING_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::PIERCING_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCode::PIERCING_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::PIERCING_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::PIERCING_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::HOLLOW_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::HOLLOW_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::HOLLOW_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCode::HOLLOW_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::HOLLOW_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::HOLLOW_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::SILVER_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::SILVER_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::SILVER_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCode::SILVER_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::SILVER_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::SILVER_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],
        ];
    }

}
