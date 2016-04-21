<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTableTest;

class BowsTableTest extends AbstractShootingArmamentsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [WeaponCodes::SHORT_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [-1, 3]],
            [WeaponCodes::SHORT_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::SHORT_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::SHORT_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::SHORT_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 24],
            [WeaponCodes::SHORT_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::LONG_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [5, 7]],
            [WeaponCodes::LONG_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LONG_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::LONG_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 27],
            [WeaponCodes::LONG_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.2],

            [WeaponCodes::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [1, 6]],
            [WeaponCodes::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 26],
            [WeaponCodes::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [5, 9]],
            [WeaponCodes::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 5],
            [WeaponCodes::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 29],
            [WeaponCodes::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.5],

            [WeaponCodes::POWER_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [7, 12]],
            [WeaponCodes::POWER_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCodes::POWER_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 6],
            [WeaponCodes::POWER_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::POWER_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 31],
            [WeaponCodes::POWER_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 2.0],
        ];
    }

}
