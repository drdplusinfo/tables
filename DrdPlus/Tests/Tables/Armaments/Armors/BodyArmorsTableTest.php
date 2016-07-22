<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;

class BodyArmorsTableTest extends AbstractArmorsTableTest
{
    public function provideArmorAndValue()
    {
        return [
            [BodyArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, false],
            [BodyArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::RESTRICTION, false],
            [BodyArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::PROTECTION, 0],
            [BodyArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::WEIGHT, false],

            [BodyArmorCode::PADDED_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, -2],
            [BodyArmorCode::PADDED_ARMOR, AbstractArmorsTable::RESTRICTION, false],
            [BodyArmorCode::PADDED_ARMOR, AbstractArmorsTable::PROTECTION, 2],
            [BodyArmorCode::PADDED_ARMOR, AbstractArmorsTable::WEIGHT, 4.0],

            [BodyArmorCode::LEATHER_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, 1],
            [BodyArmorCode::LEATHER_ARMOR, AbstractArmorsTable::RESTRICTION, false],
            [BodyArmorCode::LEATHER_ARMOR, AbstractArmorsTable::PROTECTION, 3],
            [BodyArmorCode::LEATHER_ARMOR, AbstractArmorsTable::WEIGHT, 6.0],

            [BodyArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, 3],
            [BodyArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::RESTRICTION, false],
            [BodyArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::PROTECTION, 4],
            [BodyArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::WEIGHT, 8.0],

            [BodyArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, 5],
            [BodyArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::RESTRICTION, -1],
            [BodyArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::PROTECTION, 6],
            [BodyArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::WEIGHT, 15.0],

            [BodyArmorCode::SCALE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, 7],
            [BodyArmorCode::SCALE_ARMOR, AbstractArmorsTable::RESTRICTION, -2],
            [BodyArmorCode::SCALE_ARMOR, AbstractArmorsTable::PROTECTION, 7],
            [BodyArmorCode::SCALE_ARMOR, AbstractArmorsTable::WEIGHT, 20.0],

            [BodyArmorCode::PLATE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, 10],
            [BodyArmorCode::PLATE_ARMOR, AbstractArmorsTable::RESTRICTION, -3],
            [BodyArmorCode::PLATE_ARMOR, AbstractArmorsTable::PROTECTION, 9],
            [BodyArmorCode::PLATE_ARMOR, AbstractArmorsTable::WEIGHT, 30.0],

            [BodyArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH, 12],
            [BodyArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::RESTRICTION, -4],
            [BodyArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::PROTECTION, 10],
            [BodyArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::WEIGHT, 35.0],
        ];
    }
}