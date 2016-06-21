<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Codes\ArmorCode;
use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;

class BodyArmorsTableTest extends AbstractArmorsTableTest
{
    public function provideArmorAndValue()
    {
        return [
            [ArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, false],
            [ArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 0],
            [ArmorCode::WITHOUT_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, false],

            [ArmorCode::PADDED_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, -2],
            [ArmorCode::PADDED_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCode::PADDED_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 2],
            [ArmorCode::PADDED_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 4.0],

            [ArmorCode::LEATHER_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 1],
            [ArmorCode::LEATHER_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCode::LEATHER_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 3],
            [ArmorCode::LEATHER_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 6.0],

            [ArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 3],
            [ArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 4],
            [ArmorCode::HOBNAILED_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 8.0],

            [ArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 5],
            [ArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -1],
            [ArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 6],
            [ArmorCode::CHAINMAIL_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 15.0],

            [ArmorCode::SCALE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 7],
            [ArmorCode::SCALE_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -2],
            [ArmorCode::SCALE_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 7],
            [ArmorCode::SCALE_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 20.0],

            [ArmorCode::PLATE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 10],
            [ArmorCode::PLATE_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -3],
            [ArmorCode::PLATE_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 9],
            [ArmorCode::PLATE_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 30.0],

            [ArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 12],
            [ArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -4],
            [ArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 10],
            [ArmorCode::FULL_PLATE_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 35.0],
        ];
    }
}