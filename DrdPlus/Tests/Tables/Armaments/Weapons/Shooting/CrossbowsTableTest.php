<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTableTest;

class CrossbowsTableTest extends AbstractShootingArmamentsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [WeaponCode::MINICROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -3],
            [WeaponCode::MINICROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, -1],
            [WeaponCode::MINICROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCode::MINICROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::MINICROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 19],
            [WeaponCode::MINICROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCode::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 5],
            [WeaponCode::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 36],
            [WeaponCode::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.5],

            [WeaponCode::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCode::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 7],
            [WeaponCode::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 40],
            [WeaponCode::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 2.0],

            [WeaponCode::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCode::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 10],
            [WeaponCode::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 38],
            [WeaponCode::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 3.0],
        ];
    }

}
