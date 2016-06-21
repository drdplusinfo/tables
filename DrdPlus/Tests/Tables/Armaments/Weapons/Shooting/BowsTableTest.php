<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
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
            [WeaponCode::SHORT_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [-1, 3]],
            [WeaponCode::SHORT_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::SHORT_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 1],
            [WeaponCode::SHORT_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::SHORT_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 24],
            [WeaponCode::SHORT_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::LONG_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [5, 7]],
            [WeaponCode::LONG_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LONG_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 4],
            [WeaponCode::LONG_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LONG_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 27],
            [WeaponCode::LONG_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.2],

            [WeaponCode::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [1, 6]],
            [WeaponCode::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 2],
            [WeaponCode::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 26],
            [WeaponCode::SHORT_COMPOSITE_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [5, 9]],
            [WeaponCode::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 5],
            [WeaponCode::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 29],
            [WeaponCode::LONG_COMPOSITE_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 1.5],

            [WeaponCode::POWER_BOW, AbstractShootingArmamentsTable::REQUIRED_STRENGTH_HEADER, [7, 12]],
            [WeaponCode::POWER_BOW, AbstractShootingArmamentsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCode::POWER_BOW, AbstractShootingArmamentsTable::WOUNDS_HEADER, 6],
            [WeaponCode::POWER_BOW, AbstractShootingArmamentsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::POWER_BOW, AbstractShootingArmamentsTable::RANGE_HEADER, 31],
            [WeaponCode::POWER_BOW, AbstractShootingArmamentsTable::WEIGHT_HEADER, 2.0],
        ];
    }

}
