<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
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
            [WeaponCodes::MINICROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, -3],
            [WeaponCodes::MINICROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, -1],
            [WeaponCodes::MINICROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::MINICROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::MINICROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 19],
            [WeaponCodes::MINICROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCodes::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 5],
            [WeaponCodes::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 36],
            [WeaponCodes::LIGHT_CROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.5],

            [WeaponCodes::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCodes::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 7],
            [WeaponCodes::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 40],
            [WeaponCodes::MILITARY_CROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 2.0],

            [WeaponCodes::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCodes::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 10],
            [WeaponCodes::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::RANGE_HEADER, 38],
            [WeaponCodes::HEAVY_CROSSBOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 3.0],
        ];
    }

}
