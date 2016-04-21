<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
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
            [WeaponCodes::BASIC_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::BASIC_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::BASIC_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::BASIC_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::BASIC_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::BASIC_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::WAR_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::WAR_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::WAR_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::WAR_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::WAR_DART, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCodes::WAR_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCodes::PIERCING_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::PIERCING_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::PIERCING_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCodes::PIERCING_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::PIERCING_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::PIERCING_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::HOLLOW_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::HOLLOW_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::HOLLOW_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCodes::HOLLOW_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::HOLLOW_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::HOLLOW_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::SILVER_DART, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::SILVER_DART, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::SILVER_DART, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::SILVER_DART, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::SILVER_DART, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::SILVER_DART, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],
        ];
    }

}
