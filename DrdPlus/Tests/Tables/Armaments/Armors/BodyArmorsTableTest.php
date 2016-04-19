<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Codes\ArmorCodes;
use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;

class BodyArmorsTableTest extends AbstractArmorsTableTest
{
    public function provideArmorAndValue()
    {
        return [
            [ArmorCodes::WITHOUT_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, false],
            [ArmorCodes::WITHOUT_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::WITHOUT_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 0],
            [ArmorCodes::WITHOUT_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, false],

            [ArmorCodes::PADDED_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, -2],
            [ArmorCodes::PADDED_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::PADDED_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 2],
            [ArmorCodes::PADDED_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 4.0],

            [ArmorCodes::LEATHER_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 1],
            [ArmorCodes::LEATHER_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::LEATHER_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 3],
            [ArmorCodes::LEATHER_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 6.0],

            [ArmorCodes::HOBNAILED_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 3],
            [ArmorCodes::HOBNAILED_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::HOBNAILED_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 4],
            [ArmorCodes::HOBNAILED_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 8.0],

            [ArmorCodes::CHAINMAIL_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 5],
            [ArmorCodes::CHAINMAIL_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -1],
            [ArmorCodes::CHAINMAIL_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 6],
            [ArmorCodes::CHAINMAIL_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 15.0],

            [ArmorCodes::SCALE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 7],
            [ArmorCodes::SCALE_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -2],
            [ArmorCodes::SCALE_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 7],
            [ArmorCodes::SCALE_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 20.0],

            [ArmorCodes::PLATE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 10],
            [ArmorCodes::PLATE_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -3],
            [ArmorCodes::PLATE_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 9],
            [ArmorCodes::PLATE_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 30.0],

            [ArmorCodes::FULL_PLATE_ARMOR, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 12],
            [ArmorCodes::FULL_PLATE_ARMOR, AbstractArmorsTable::RESTRICTION_HEADER, -4],
            [ArmorCodes::FULL_PLATE_ARMOR, AbstractArmorsTable::PROTECTION_HEADER, 10],
            [ArmorCodes::FULL_PLATE_ARMOR, AbstractArmorsTable::WEIGHT_HEADER, 35.0],
        ];
    }
}