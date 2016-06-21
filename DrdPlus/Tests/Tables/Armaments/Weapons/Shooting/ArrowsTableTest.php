<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
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
            [WeaponCode::BASIC_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::BASIC_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::BASIC_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCode::BASIC_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::BASIC_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::BASIC_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCode::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 2],
            [WeaponCode::LONG_RANGE_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::WAR_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::WAR_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::WAR_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCode::WAR_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::WAR_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCode::WAR_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.1],

            [WeaponCode::PIERCING_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::PIERCING_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::PIERCING_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCode::PIERCING_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::PIERCING_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::PIERCING_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::HOLLOW_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::HOLLOW_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::HOLLOW_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -1],
            [WeaponCode::HOLLOW_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::HOLLOW_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::HOLLOW_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::CRIPPLING_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::CRIPPLING_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, -1],
            [WeaponCode::CRIPPLING_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -2],
            [WeaponCode::CRIPPLING_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::CRIPPLING_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, -1],
            [WeaponCode::CRIPPLING_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::INCENDIARY_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::INCENDIARY_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, -3],
            [WeaponCode::INCENDIARY_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, -3],
            [WeaponCode::INCENDIARY_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::INCENDIARY_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, -2],
            [WeaponCode::INCENDIARY_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],

            [WeaponCode::SILVER_ARROW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::SILVER_ARROW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::SILVER_ARROW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 0],
            [WeaponCode::SILVER_ARROW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::SILVER_ARROW, AbstractShootingArmamentsTable::RANGE_HEADER, 0],
            [WeaponCode::SILVER_ARROW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 0.05],
        ];
    }

}
