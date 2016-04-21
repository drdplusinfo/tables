<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTableTest;

class ArrowsTableTest extends AbstractShootingArmamentsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [WeaponCodes::BASIC_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::BASIC_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::BASIC_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::BASIC_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::BASIC_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::BASIC_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCodes::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 2],
            [WeaponCodes::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::WAR_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::WAR_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::WAR_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::WAR_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::WAR_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCodes::WAR_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCodes::PIERCING_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::PIERCING_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::PIERCING_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCodes::PIERCING_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::PIERCING_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::PIERCING_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::HOLLOW_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::HOLLOW_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::HOLLOW_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCodes::HOLLOW_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::HOLLOW_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::HOLLOW_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::CRIPPLING_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::CRIPPLING_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, -1],
            [WeaponCodes::CRIPPLING_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -2],
            [WeaponCodes::CRIPPLING_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::CRIPPLING_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, -1],
            [WeaponCodes::CRIPPLING_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::INCENDIARY_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::INCENDIARY_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, -3],
            [WeaponCodes::INCENDIARY_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -3],
            [WeaponCodes::INCENDIARY_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::INCENDIARY_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCodes::INCENDIARY_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCodes::SILVER_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCodes::SILVER_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::SILVER_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::SILVER_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::SILVER_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCodes::SILVER_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],
        ];
    }

}
