<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Codes\ArmorCodes;
use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;

class HelmsTableTest extends AbstractArmorsTableTest
{
    public function provideArmorAndValue()
    {
        return [
            [ArmorCodes::WITHOUT_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, false],
            [ArmorCodes::WITHOUT_HELM, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::WITHOUT_HELM, AbstractArmorsTable::PROTECTION_HEADER, 0],
            [ArmorCodes::WITHOUT_HELM, AbstractArmorsTable::WEIGHT_HEADER, false],

            [ArmorCodes::LEATHER_CAP, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 0],
            [ArmorCodes::LEATHER_CAP, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::LEATHER_CAP, AbstractArmorsTable::PROTECTION_HEADER, 1],
            [ArmorCodes::LEATHER_CAP, AbstractArmorsTable::WEIGHT_HEADER, 0.3],

            [ArmorCodes::CHAINMAIL_HOOD, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 2],
            [ArmorCodes::CHAINMAIL_HOOD, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::CHAINMAIL_HOOD, AbstractArmorsTable::PROTECTION_HEADER, 2],
            [ArmorCodes::CHAINMAIL_HOOD, AbstractArmorsTable::WEIGHT_HEADER, 1.2],

            [ArmorCodes::CONICAL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 3],
            [ArmorCodes::CONICAL_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -1],
            [ArmorCodes::CONICAL_HELM, AbstractArmorsTable::PROTECTION_HEADER, 3],
            [ArmorCodes::CONICAL_HELM, AbstractArmorsTable::WEIGHT_HEADER, 1.5],

            [ArmorCodes::FULL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 4],
            [ArmorCodes::FULL_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -1],
            [ArmorCodes::FULL_HELM, AbstractArmorsTable::PROTECTION_HEADER, 4],
            [ArmorCodes::FULL_HELM, AbstractArmorsTable::WEIGHT_HEADER, 2.0],

            [ArmorCodes::BARREL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 5],
            [ArmorCodes::BARREL_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -2],
            [ArmorCodes::BARREL_HELM, AbstractArmorsTable::PROTECTION_HEADER, 5],
            [ArmorCodes::BARREL_HELM, AbstractArmorsTable::WEIGHT_HEADER, 3.0],

            [ArmorCodes::GREAT_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 7],
            [ArmorCodes::GREAT_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -3],
            [ArmorCodes::GREAT_HELM, AbstractArmorsTable::PROTECTION_HEADER, 7],
            [ArmorCodes::GREAT_HELM, AbstractArmorsTable::WEIGHT_HEADER, 4.0],
        ];
    }
}